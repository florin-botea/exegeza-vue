import Axios from '../orm/axios';
import Action from './Action'
import Context from '../common/context'

export default class Create extends Action {
  /**
   * Call $create method
   * @param {object} store
   * @param {object} params
   */
  static async call ({ state, commit }, params = {}) {
    if(!params.data || typeof params !== 'object') {
      throw new TypeError("You must include a data object in the params to send a POST request", params)
    }

    const context = Context.getInstance();
    const model = context.getModelFromState(state);
    const endpoint = Action.transformParams('$create', model, params);
    const axios =  new Axios(model.methodConf.http);
    const method = Action.getMethod('$create', model, 'post');
    const request = axios[method](endpoint, params.data);
	
	//am adaugat niste hook-uri inainte si dupa ce se face request. le pot defini in model
	let goodToGo = true
	if (model.observer && model.observer.beforeCreate){
		goodToGo = await model.observer.beforeCreate( params.data )
	}
	if (goodToGo){
		this.onRequest(commit);
		request
		  .then(data => this.onSuccess(commit, model, data))
		  .catch(error => this.onError(commit, error))

		return request;
	}
	return false
	//
  }

  /**
   * On Request Method
   * @param {object} commit
   */
  static onRequest(commit) {
    commit('onRequest');
  }

  /**
   * On Successful Request Method
   * @param {object} commit
   * @param {object} model
   * @param {object} data
   */
  static onSuccess(commit, model, data) {
    commit('onSuccess')
    model.insertOrUpdate({
      data,
    });
	//am adaugat niste hook-uri inainte si dupa ce se face request. le pot defini in model
	if (model.observer && model.observer.created){
		model.observer.created( model.find(params.params.id || data.id) )
	}
	//
  }

  /**
   * On Failed Request Method
   * @param {object} commit
   * @param {object} error
   */
  static onError(commit, error) {
    commit('onError', error)
  }
}

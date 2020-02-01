import Axios from '../orm/axios';
import Action from './Action'
import Context from '../common/context'

export default class Delete extends Action {
  /**
   * Call $delete method
   * @param {object} store
   * @param {object} params
   */
  static async call ({ state, commit }, params = {}) {
    const context = Context.getInstance();
    const model = context.getModelFromState(state);
    const endpoint = Action.transformParams('$delete', model, params);
    const axios =  new Axios(model.methodConf.http);
    const method = Action.getMethod('$delete', model, 'delete');
    const request = axios[method](endpoint);

	//am adaugat niste hook-uri inainte si dupa ce se face request. le pot defini in model
	let goodToGo = true
	if (model.observer && model.observer.beforeDelete){
		goodToGo = await model.observer.beforeDelete( model.find(params.params.id || data.id) )
	}
	if (goodToGo){
		this.onRequest(model, params);
		request
		  .then(data => this.onSuccess(model, params, data))
		  .catch(error => this.onError(model, params, error))

		return request;
	}
	return false
	//
  }

  /**
   * On Request Method
   * @param {object} model
   * @param {object} params
   */
  static onRequest(model, params) {
    model.update({
      where: params.params.id,
      data: {
        $isDeleting: true,
        $deleteErrors: []
      }
    })
  }

  /**
   * On Successful Request Method
   * @param {object} model
   * @param {object} params
   * @param {object} data
   */
  static onSuccess(model, params, data) {
    model.delete({
      where: params.params.id || data.id,
    })
	//am adaugat niste hook-uri inainte si dupa ce se face request. le pot defini in model
	if (model.observer && model.observer.deleted){
		model.observer.deleted( model.find(params.params.id || data.id) )
	}
	//
  }

  /**
   * On Failed Request Method
   * @param {object} model
   * @param {object} params
   * @param {object} error
   */
  static onError(model, params, error) {
    model.update({
      where: params.params.id,
      data: {
        $isDeleting: false,
        $deleteErrors: error
      }
    })
  }
}

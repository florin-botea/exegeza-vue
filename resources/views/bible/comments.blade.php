	<!--COMMENTS-->
	<div class="col-lg-5 col-md-5 comments-section">
		<div class="container bg-warning" id="comments-header" data-targetId="123">
			Comentarii
		</div>

		<div class="container comments-container" style="overflow-y:auto;">
			<!--CARD COMM-->
			@if ($data['comments']['comments_nr'] > 5)
				<a class="text-primary" id="load-more-comments">încarca mai multe comentarii</a>
			@endif
			@foreach ($data['comments']['comments'] as $comment)
				<div class="card p-1 mb-1" id="comment-{{$comment['id']}}"><!--comment id here-->
					<!--HEADER-->
					<div class="d-flex flex-row justify-content-between">
						<h6>
						{{$comment['author']['username']}}
						</h6>
						<small>
							{{$comment['meta']['date']}}
						</small>
					</div>
					<!--end HEADER-->
					<h5>
						{{$comment['title']}}
					</h5>
					<!--STATS-->
					<div class="stats d-flex flex-row justify-content-start">
						<p class="badge">Eretic</p>
						<p class="badge">Nebun</p>
					</div>

					<!--end STATS-->
					<div class="content">
						{{$comment['text']}}
					</div>
					<hr>
					<!--TAGS-->
					<div class="d-flex flex-row justify-content-start">
						<p class="badge badge-secondary">{{$comment['meta']['tags']}}</p>
					</div>
					<!--end TAGS-->
					<div>
						<span class="badge badge-primary">{{$comment['meta']['links']}}</span>
					</div>
					<!--FOOTER-->
					<div class="d-flex flex-row justify-content-between">
						<p>
							@if ($data['user']->haveAccessTo('comment'))
								<span class="font-weight-bold text-danger">sterge</span>
								<span class="font-weight-bold text-success">editează</span>
								<span class="font-weight-bold text-warning">raportează</span>
							@endif
						</p>
					</div>
					<a class="js-show-reactions text-primary" data-href="/comments/{{$comment['id']}}/replies?start=0&end=10">vezi reactiile</a>
					<a class="js-add-reply text-primary">adauga reply</a>
					<!--end FOOTER-->
				</div>
			@endforeach
			<!--end POST-->
			<a class="js-add-comment font-weight-bold text-primary">adaugă un comentariu</a>
		</div>
		
	</div>
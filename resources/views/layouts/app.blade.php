@php
	$comments = isset($data) ? $data['comments']??null : null;
	$replies = isset($data) ? $data['replies']??null : null;
@endphp
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href='/css/app.css'>
		<!--link rel="stylesheet" href='/css/main.css'-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<title>Exegeza biblica</title>
		<style>
			body {
				font-family: "Times New Roman", Times, serif;
			}
		</style>
	</head>
	<body>
		<div class="flex flex-col w-full min-h-full app-background" id="app" style="height:100vh">
			<bootstrap
				:auth='@json($auth)'
				:comments='@json($comments)'
				:replies='@json($replies)'
				:bible-data='@json($data ?? null)'
				:route='@json(['parameters' => request()->route()->parameters(), 'queryStrings' => request()->query()])'
			></bootstrap>
			<div id="pseudo_navbar" class="border-b border-yellow-300 fixed flex w-full bg-gray-800 h-12 z-50">
				<!-- acesta tine locul barei de navigare pentru a pastra proportia lucrurilor la incarcarea paginii -->
			</div>
			<navbar class="sticky top-0"></navbar>
			<div class="w-full h-full">
				@yield('content')
			</div>
		</div>

		<script>
			//yield('content')
			var $data = <?php echo isset($data) ? json_encode($data) : 'null'; ?>;
			const $_appData = {
				auth: @json($auth)
			}
			var bible_versions = $data['versions'] || null;
			var preloaded_comments = $data['comments'] || null;
			var preloaded_replies = $data['replies'] || null;
			var $verses = $data['verses'] || [];

			console.log({preloaded_comments, preloaded_replies})
			console.log({$verses})
			console.log({auth:$_appData.auth})
			//console.log(user.permissions.map( (perm) => perm.name ))
			var route = {
				parameters: <?php echo json_encode(request()->route()->parameters()); ?>,
				queryStrings: <?php echo json_encode(request()->query()); ?>
			}
		</script>
		<script src="/js/main-app.js"></script>
		<script>
			//setAuthData(user)
			//setPreloadedComments(preloaded_comments)
			//setPreloadedReplies(preloaded_replies)

			$(document).ready(function(){

				$('#selected_version').on('change', function (e){
					$(location).attr('href', e.target.value)
				})

				$('#search-criteria-version').on('change', function(e){
					let alias = e.target.value
					VueBus.$emit('search-criteria-version-changed', alias)
				})
				
				$('form').submit(function(){
					$(this).find('button[type=submit]').prop('disabled', true);
				});
			})
		</script>
		<div style="display:none;">
	</body>
</html>

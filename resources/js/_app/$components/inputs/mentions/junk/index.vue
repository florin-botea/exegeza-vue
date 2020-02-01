<template>
	<div>
		<div>
			<span class="badge badge-primary" @click="showMentionForm('user')">User</span>
			<span class="badge badge-success" @click="showMentionForm('verse')">Verse</span>
			<span class="badge badge-secondary" @click="showMentionForm('comment')">Comment</span>
			<span class="badge badge-secondary" @click="showMentionForm('reply')">Reply</span>
			<span class="badge badge-info" @click="showMentionForm('url')">Link</span>
			<span class="badge badge-light" @click="setTextSelection()">Note</span>
		</div>
		
		<div class="position-relative" style="z-index:2">		
			<UserMention v-if="mention_form === 'user'" @submit="insert" @abort="mention_form=''"/>
			<VerseMention v-if="mention_form === 'verse'" @submit="insert" @abort="mention_form=''"/>
			<CommentMention v-if="mention_form === 'comment'" @submit="insert" @abort="mention_form=''"/>
			<ReplyMention v-if="mention_form === 'reply'" @submit="insert" @abort="mention_form=''"/>
			<UrlMention v-if="mention_form === 'url'" @submit="insert" @abort="mention_form=''"/>
			<NoteMention :text="textSelection" v-if="mention_form === 'note'" @submit="insert" @abort="mention_form=''"/>
		</div>
	</div>
</template>

<sc
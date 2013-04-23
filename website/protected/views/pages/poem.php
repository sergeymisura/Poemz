<div class="poem" data-controller="poem">
	<div class="row" data-template="poem">
		<div class="span7">
			<div class="title">${ title }</div>
			<div class="author">by <a href="">${ author.name }</a></div>
			<div class="poem-text"><pre>${ text }</pre></div>
			<div class="record" id="poem-page-record"><button class="btn record-yours">Record your version</button><button class="btn stop-recording">Stop</button></div>
		</div>
		<div class="span5">
			<h4>Poem recitations</h4>
			{{each recitals }}
			<div class="recital">
				<div class="pull-left index">${ $index + 1 }</div>
				<div class="pull-left">
					<div>read by <a href="">${ performer.username }</a> 1 day ago</div>
					<audio width="350px" src="${ audioUrl($index) }"></audio>
				</div>
			</div>
			{{/each}}
		</div>
	</div>
</div>
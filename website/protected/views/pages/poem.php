<div class="poem" data-controller="poem">
	<div class="row" data-template="poem">
		<div class="span7">
			<div class="title">${ title }</div>
			<div class="author">by <a href="">${ author.name }</a></div>
			<div class="poem-text"><pre>${ text }</pre></div>
			<div class="record"><button class="btn record-yours">Create your own version</button></div>
		</div>
		<div class="span5">
			<div class="popover popover-recorder">
				<div class="wami-placeholder"></div>
				<div class="popover-content">
					<div class="step1">
						<div><button class="btn btn-primary btn-large start-recording">Click to start recording</button></div>
						<div class="big-or">&mdash; or &mdash;</div>
						<div><button class="btn btn-large">Upload a file</button></div>
					</div>
					<div class="step2">
						<h4>Recording will start in...</h4>
						<div class="number countdown">10</div>
						<h4 class="footer">seconds</h4>
						<div><button class="btn btn-large i-am-chicken">Stop it, I'm scared!</button></div>
					</div>
					<div class="step3">
						<h4>Recording in progess...</h4>
						<div class="number timer">00:00</div>
						<div><button class="btn btn-large btn-primary save-recording">Finish &amp; save!</button></div>
						<div class="big-or">&mdash; or &mdash;</div>
						<div><button class="btn btn-large cancel-recording">Cancel &amp; discard</button></div>
					</div>
					<div class="step4">
						<h4>Uploading your perfomance...</h4>
						<div>Please stand by.</div>
					</div>
					<div class="step5">
						<h4>Uploaded!</h4>
						<div>Review it and see if you like it:</div>
						<div class="preview-placeholder"></div>
						<div><button class="btn btn-primary btn-large submit-recording">It's good, save it!</button></div>
						<div class="big-or">&mdash; or &mdash;</div>
						<div><button class="btn btn-large start-recording">Nah, I want to do it again</button></div>
					</div>
				</div>
			</div>
			<h4>Poem recitations</h4>
			{{each latest }}
			<div class="recital">
				<div class="pull-left index">${ $index + 1 }</div>
				<div class="pull-left">
					<div>read by <a href="">${ performer.username }</a> 1 day ago</div>
					<audio width="350px" src="${ audioUrl(id) }"></audio>
				</div>
			</div>
			{{/each}}
		</div>
	</div>
</div>
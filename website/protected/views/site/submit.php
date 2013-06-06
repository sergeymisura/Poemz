<div class="submit-poem" data-controller="submit-poem">
	<h3>Submit a new poem</h3>
	<form class="form-horizontal">
		<div class="control-group">
			<label class="control-label">Poem title:</label>
			<div class="controls"><input type="text" class="input-xlarge" data-required="value"/></div>
		</div>
		<div class="control-group">
			<label class="control-label">Author's name:</label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="author" data-required="value"/>
				<div class="popover bottom popover-search" data-close="auto">
					<div class="arrow"></div>
					<div class="popover-content">
						test
					</div>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Poem text:</label>
			<div class="controls"><textarea data-required="value"></textarea></div>
		</div>
	</form>
</div>
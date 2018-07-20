<form class="searchbox">
    <div class="input-group input-group-sm">
        <input <?=(!empty($search_box_id)? 'id="'.$search_box_id.'"' :'')?> type="search" class="form-control">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="button"><i class="fa fa-search"></i> Search</button>
						</span>
    </div>
</form>
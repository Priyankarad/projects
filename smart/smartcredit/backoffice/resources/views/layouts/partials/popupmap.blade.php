<div class="modal fade" id="popup-map" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="login-tabs">
                    <li class="active">View Map</li>
                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
                
				<div class="mapcontainer animated zoomIn">
					
					<div class="alert alert-success animated shake" id="comparelistnotify" style="display:none">
						<strong id="comparelistcount"></strong> Property(s) are currently in compare list. <a href="{{ URL::route('myaccountcomparelist') }}" target="_blank">View Comparison</a>
					</div>
					
					<div id="mapcanvas" style="height:500px; width:100%;">
						
						
						
					</div>
					
					<div style="float:right; margin:16px 0 0 0"><a href="javascript:void(0);" class="btn btn-primary bulkaddtocomparelist">Add To Compare List</a></div>
								
					<div style="clear:both"></div>
					
					<!--start latest listing module-->
					<div class="houzez-module" style="padding:0">
						<!--start list tabs-->
						<div class="list-tabs table-list full-width">
							<div class="tabs table-cell">
								<h2 class="tabs-title propertiesneartitle">Properties Near</h2>
							</div>
							<!--<div class="sort-tab table-cell text-right">
								<span class="view-btn btn-list active"><i class="fa fa-th-list"></i></span>
								<span class="view-btn btn-grid"><i class="fa fa-th-large"></i></span>
							</div>-->
						</div>
						<!--end list tabs-->
						<div class="property-listing list-view">
							<div class="row" id="mapnearbyproperties">
								
								
								
							</div>
						</div>
					</div>
					<!--end latest listing module-->
				
				</div>
				
				<div class="mapcompare"></div>
				
            </div>
        </div>
    </div>
</div>
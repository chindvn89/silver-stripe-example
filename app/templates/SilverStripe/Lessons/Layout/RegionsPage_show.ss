		
		<!-- BEGIN CONTENT WRAPPER -->
		<div class="content">
			<div class="container">
				<div class="row">
					
                    <div class="main col-sm-8">
                        <% with $Region %>
                            <h2>$Title</h2>
                            <div class="blog-main-image">
                                $Photo.ScaleWidth(750)
                            </div>
                            $Description
                        <% end_with %>
                    </div>

                    <div class="sidebar gray col-sm-4">
                        <h2 class="section-title">Regions</h2>
                        <ul class="categories subnav">
                            <% loop $Regions %>
                                <li class="$LinkingMode"><a class="$LinkingMode" href="$Link">$Title</a></li>
                            <% end_loop %>
                        </ul>
                    </div>
					
					<!-- BEGIN SIDEBAR -->
					<div class="sidebar gray col-sm-4">
					
						
						<!-- BEGIN LATEST NEWS -->
						<h2 class="section-title">Popular articles</h2>
						<ul class="latest-news">
							<li class="col-md-12">
								<div class="image">
									<a href="blog-detail.html"></a>
									<img src="http://placehold.it/100x100" alt="" />
								</div>
								
								<ul class="top-info">
									<li><i class="fa fa-calendar"></i> 30 July 2014</li>
								</ul>
									
								<h4><a href="#">It's all about the Northeast</a></h4>
							</li>
							<li class="col-md-12">
								<div class="image">
									<a href="blog-detail.html"></a>
									<img src="http://placehold.it/100x100" alt="" />
								</div>
								
								<ul class="top-info">
									<li><i class="fa fa-calendar"></i> 20 July 2014</li>
								</ul>
									
								<h4><a href="#">Southwest: Best ever</a></h4>
							</li>
							<li class="col-md-12">
								<div class="image">
									<a href="blog-detail.html"></a>
									<img src="http://placehold.it/100x100" alt="" />
								</div>
								
								<ul class="top-info">
									<li><i class="fa fa-calendar"></i> 10 July 2014</li>
								</ul>
									
								<h4><a href="#">I went to the Northwest and stole from and old lady</a></h4>
							</li>

						</ul>
						<!-- END LATEST NEWS -->
						
					</div>
					<!-- END SIDEBAR -->

				</div>
			</div>
		</div>
		<!-- END CONTENT WRAPPER -->

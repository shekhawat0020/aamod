
    
        <!-- COL END -->
							
                                    <div class="row">
										<div class="form-group col-sm-12">
											<label class="form-label">Title : {{$post->title}}</label>
                                        </div>
										
										<div class="form-group col-sm-12">
											<label class="form-label">Category: 
												@if($post->category == 1) News @endif
											*</label>
										</div>
                                        
                                        <div class="form-group col-sm-12">
											<label class="form-label">Description: {{$post->description}}</label>
											</div>
                                        <div class="form-group col-sm-12">
											<label class="form-label">Status: 
												@if($post->status == 1) Active @endif
												@if($post->status == 0) InActive @endif
											</label>
										
                                    </div>
                                    </div>
                                    
                                    
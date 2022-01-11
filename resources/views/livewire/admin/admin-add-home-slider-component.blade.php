<div>
    <div class="container" style="padding:30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Add New Slider
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.homeslider')}}" class="btn btn-success pull-right">All Sliders</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert alert-success">
                                {{Session::get('message')}}
                            </div>
                        @endif
                        <form class="form-horizontal" wire:submit.prevent="addSlide">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Slider Title</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Slider Title" class="form-control input-md" wire:model="title"  />

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Slider Subtitle</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Slider Subtitle" class="form-control input-md" wire:model="subtitle" />

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Slider Price</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Slider Price" class="form-control input-md" wire:model="price" />

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Slider Link</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Slider Link" class="form-control input-md" wire:model="link" />

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Slider Image</label>
                                <div class="col-md-4">
                                    <input type="file"  class="input-file" wire:model="image" />
                                    @if($image)
                                        <img src="{{$image->temporaryURL()}}" width="120"  />
                                    @endif

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Slider Image</label>
                                <div class="col-md-4">
                                    <select class="form-control"  wire:model="status">
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Add Slider</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div id="nininew-video-form" class=''> -->
<div id="new-video-form" class='modal fade' tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/video/add" accept-charset="UTF-8" class="form-horizontal" role="form">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                 <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add A Video</h4>
                </div>
                 <div class="modal-body">
                     <div class="panel-body" style="padding: 10px;">
                                @include('partials.new_video_form')
                     </div>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="add-video btn-teach-tech">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
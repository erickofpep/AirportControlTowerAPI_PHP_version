
<!--Add Task Modal -->
<div id="AddTaskModal" class="modalWrap">
  <div class="modal-content">
    <div class="modal-header">
      <span id="closePayModal" class="closeMsgWrap">&times;</span>
      <h2>Add Task</h2>
    </div>
    <div class="modal-body">
        
<form class="addTaskFrm" method="post"> 
      <div class="modal-body ">
        <div class="container">
        <div class="row editCntnt">
    
    <div class="col-md-12 position-relative form-group">
    <label for="exampleEmail" class>Title</label>
    <input type="text" name="Title" id="Title" placeholder=""  class="form-control" value="" required>
    </div>
    
    <div class="col-md-12 position-relative form-group">
    <label for="exampleEmail" class>Description</label>
    <textarea name="task_desc" id="task_desc" placeholder="" rows="6" class="form-control" value="" required></textarea>
    </div>

    <div class="col-md-12 position-relative form-group">
    <label for="exampleEmail" class>Due date</label>
    <input type="date" name="Duedate" id="Duedate" placeholder=""  class="form-control" value="" required>
    </div>
    
    
        </div>
      </div>  
      </div>
    <div class="row modal-footer">
    <button type="button" class="btn btn-primary DelUserOKBtn AddTaskBtn">Add Task</button> 
    <button type="button" class="btn btn-secondary cancelMsgWrap" id="cancelPayModal">Cancel</button>
    </div>
</form>
  </div>
</div>
</div>


<!--Set Priority Modal -->
<div id="SetPriorityModal" class="modalWrap">
  <div class="modal-content">
    <div class="modal-header">
      <span id="closePriotyModal" class="closeMsgWrap">&times;</span>
      <h2>Set Task Priority</h2>
    </div>
    <div class="modal-body">
        
<form class="addTaskFrm" method="post"> 
      <div class="modal-body ">
        <div class="container">
        <div class="row editCntnt">
    <input type="hidden" id="taskIDinput"/>
    <div class="col-md-12 position-relative form-group">
    <label for="exampleEmail" class>Select Priority</label>
    <select name="selectPriority" id="selectPriority" class="form-control" value="" required>
      <option value="">- select -</option>
      <option value="3">High</option>
      <option value="2">Medium</option>
      <option value="1">Low</option>
      <option value="0">no priority</option>
    </select>
    </div>
    
        </div>
      </div>  
      </div>
    <div class="row modal-footer">
    <button type="button" class="btn btn-primary DelUserOKBtn SetPrtyBtn">Set</button> 
    <button type="button" class="btn btn-secondary cancelMsgWrap" id="cancelPriotyModal">Cancel</button>
    </div>
</form>
  </div>
</div>
</div>

<!--Set Status Modal -->
<div id="taskStatusModal" class="modalWrap">
  <div class="modal-content">
    <div class="modal-header">
      <span id="closeStatusModal" class="closeMsgWrap">&times;</span>
      <h2>Set Task Status</h2>
    </div>
    <div class="modal-body">
        
<form class="addTaskFrm" method="post"> 
      <div class="modal-body ">
        <div class="container">
        <div class="row editCntnt">
    <input type="hidden" id="taskID4Status"/>
    <div class="col-md-12 position-relative form-group">
    <label for="exampleEmail" class>Select Status</label>
    <select name="selectStatusInput" id="selectStatusInput" class="form-control" value="" required>
      <option value="">- select -</option>
      <option value="open">Open</option>
      <option value="in_progress">In Progress</option>
      <option value="completed">Completed</option>
    </select>
    </div>
    
        </div>
      </div>  
      </div>
    <div class="row modal-footer">
    <button type="button" class="btn btn-primary DelUserOKBtn setStatusOKBtn">Set</button> 
    <button type="button" class="btn btn-secondary cancelMsgWrap" id="cancelStatusModal">Cancel</button>
    </div>
</form>
  </div>
</div>
</div>


<!--Edit Task Modal *********** -->
<div id="editTaskModal" class="modalWrap">
  <div class="modal-content">
    <div class="modal-header">
      <span id="closeEdtTskModal" class="closeMsgWrap">&times;</span>
      <h2>Edit Task</h2>
    </div>
    <div class="modal-body edtContent">
        
<form class="edtPymntFrm" method="post"> 
      <div class="modal-body">
        <div class="container">
        <div class="row editCntnt">
        </div>
      </div>  
      </div>
    <div class="row modal-footer">
    <button type="submit" class="btn btn-primary DelUserOKBtn saveTaskBtn">Save</button> 
    <button type="button" class="btn btn-secondary cancelMsgWrap" id="cancelEdtTskModal">Cancel</button>
    </div>
</form>
  </div>
</div>
</div>


<!--Delete User Modal -->
<div id="deleteTaskModal" class="modalMsg">
  <div class="modal-content">
    <div class="modal-header">
      <span id="closeDelTaskModal" class="closeMsgWrap">&times;</span>
    </div>
    <div class="modal-body" style="text-align: center;">
    <input type="hidden" id="delID_inpt" />
        <p>
            Are You Sure You Want To Delete This Task ?
        </p>
    <div class="row modal-footer">
    <button type="submit" class="btn btn-primary dltTaskOKBtn">Ok</button> 
    <button type="button" class="btn btn-secondary cancelMsgWrap" id="cancelDelTaskModal">Cancel</button>
    </div>
  </div>
</div>
</div>


<!--Assign Task Modal -->
<div id="asignTaskModal" class="modalWrap">
  <div class="modal-content">
    <div class="modal-header">
      <span id="closeAsgnTaskModal" class="closeMsgWrap">&times;</span>
      <h2>Assign Task</h2>
    </div>
    <div class="modal-body">
        
<form class="addTaskFrm" method="post"> 
      <div class="modal-body ">
        <div class="container">
        <div class="row editCntnt">
    <input type="hidden" id="taskID4ToAsign"/>
    <input type="hidden" id="UserAssigner" value="@if ( auth()->user()->id ){{ auth()->user()->id }} @endif"/>
    <div class="col-md-12 position-relative form-group">
    <label for="exampleEmail" class>Assign to:</label>
    <select name="userAssignee" id="userAssignee" class="form-control" value="" required>
      <option value="">- select User-</option>
      @php
      $users= App\User::all();
      @endphp
      @foreach($users as $user)
      <option value="{{ $user->id }}">{{ $user->firstname }}{{ $user->lastname }}</option>
     @endforeach
    </select>
    </div>
    
        </div>
      </div>  
      </div>
    <div class="row modal-footer">
    <button type="button" class="btn btn-primary DelUserOKBtn AsgnTaskOKBtn">Assign</button>
    <button type="button" class="btn btn-secondary cancelMsgWrap" id="cancelAsgnTaskModal">Cancel</button>
    </div>
</form>
  </div>
</div>
</div>

<!--Message Prompt Modal -->
<div id="MsgModalSucc" class="modalMsg">
  <div class="modal-content">
    <div class="modal-header">
      <span class="closeMsgSucc" id="closeMsgBtn" >&times;</span>
    </div>
    <div class="modal-body MsgPrompt">
    </div>
    <div class="modal-footer">
    </div>
  </div>
</div>


<!--Success Message Modal -->
<div id="MsgModal" class="modalMsg">
  <div class="modal-content">
    <div class="modal-header">
      <span class="closeMsg">&times;</span>
    </div>
    <div class="modal-body MsgPrompt">
    </div>
    <div class="modal-footer">
    </div>
  </div>
</div>



<!--Error Message Modal -->
<div id="ErrorMsgModal" class="modalMsg">
  <div class="modal-content">
    <div class="modal-header">
      <span class="closeErrorMsg" id="closeErrorMsg">&times;</span>
    </div>
    <div class="modal-body MsgPrompt">
    </div>
    <div class="modal-footer">
    </div>
  </div>
</div>


<div class="app-wrapper-footer ftrNav">
                    <div class="app-footer ftrWrap">
                    <div class="app-footer__inner ftrTp">
                            <div class="app-footer-left">
                                <div class="footer-dots">
                                    <div class="dropdown">
                                <a href="{{ route('dashboard') }}" aria-haspopup="true" aria-expanded="false" data-toggle="" class="dot-btn-wrapper">
<i class="metismenu-icon pe-7s-settings icon-gradient bg-mean-fruit ftrIcns"></i> Home
</a>
                                    </div>
                                    <div class="dots-separator"></div>
                                    <div class="dropdown">
                                        <a href="{{ route('dashboard') }}" class="dot-btn-wrapper" aria-haspopup="true" data-toggle="" aria-expanded="false">
<i class="metismenu-icon pe-7s-cloud dot-btn-icon lnr-earth icon-gradient bg-happy-itmeo"></i>Weather info
</a>
                                    </div>
                                    <div class="dots-separator"></div>
                                    
                                </div>
                            </div>
                        </div>  
                        <div class="app-footer__inner ftrBtmTxt">
                            Copyright <?php echo date('Y');?> Airport Control Tower API Dashboard | All rights reserved.
                        </div>    
    </div>
</div>

<script type='text/javascript' src="{{ asset('assets/js/jquery-3.7.0.js') }}" id='jquery-js'></script>

<script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/taskms.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/procTasks.js') }}"></script>

    <script>
    upload_image.onchange = evt => {
      const [file] = upload_image.files
      if (file) {
        blahPhoto.src = URL.createObjectURL(file)
      }
    }
</script>
<script>
$(document).on("input", "#PhoneNumber", function (e) {
  this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1');
  $(this).attr({"minlength": "10","maxlength": "18"});
  });
</script>

<script>
$(document).on("input", "#NextOfKinNamePhone", function (e) {
  this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1');
  $(this).attr({"minlength": "10","maxlength": "18"});
  });
</script>

<script>
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$(".AddTaskBtn").on("click", function(e) {
    e.preventDefault();

if ($('#Title').val() == '') {

$('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text('Please enter Title');

} else if ($('#Description').val() == '') {

$('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text('Please enter Description');

} else if ($('#Duedate').val() == '') {

$('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text('Please enter Due date');

} else {
             var dataString = { 
                title : $("#Title").val(),
                taskdesc : $("#task_desc").val(),
                duedate : $("#Duedate").val(),
             };

               $.ajax({
                   type: "POST",
                   url: "{{ URL::to('create_task') }}",
                   data: dataString,
                   dataType: "json",
                   cache : false,
                   success: function(data){

if(data.success){

  $('.editCntnt').addClass("loader").text("Loading..");

  setTimeout(function() {

$('#AddTaskModal').fadeOut();  
$('.editCntnt').removeClass("loader"); 

}, 1000);

$('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text(data.success);

setTimeout(function() {
  $('#MsgModalSucc').fadeOut();
   location.reload();
}, 3000);

$('#Title').val('');
  $('#Description').val('');
  $('#Duedate').val('');

}
else if(data.error){
  
$('#ErrorMsgModal').fadeIn();
$('.MsgPrompt').text(data.error);

setTimeout(function() {
  $('#ErrorMsgModal').fadeOut();
}, 3000);

}
          
    }
    });

      }
    });


// Set Priority ***************
$(".SetPrtyBtn").on("click", function(e) {
    e.preventDefault();

if ($('#selectPriority').val() == '') {

  $('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text('select Task Priority');

} else {
    var dataString = {
    taskid : $("#taskIDinput").val(),
    priorityInput : $("#selectPriority").val(),
    };

   $.ajax({
    type: "POST",
    url: "{{ URL::to('set_priority') }}",
    data: dataString,
    dataType: "json",
    cache : false,
    success: function(data){

$('.editCntnt').addClass("loader").text("Loading..");

setTimeout(function() {

  $('#SetPriorityModal').fadeOut();  
  $('.editCntnt').removeClass("loader"); 

}, 1000);

$('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text(data.success);
  
  setTimeout(function() {
    $('#MsgModalSucc').fadeOut();
     location.reload();
  }, 1000);
                       
    }
    });

      }
    });


// Set Status ***************
$(".setStatusOKBtn").on("click", function(e) {
    e.preventDefault();

if ($('#selectStatusInput').val() == '') {

  $('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text('select Task Status');

} else {
    var dataString = {
    taskid : $("#taskID4Status").val(),
    selectStatus : $("#selectStatusInput").val(),
    };

   $.ajax({
    type: "POST",
    url: "{{ URL::to('set_status') }}",
    data: dataString,
    dataType: "json",
    cache : false,
    success: function(data){

$('.editCntnt').addClass("loader").text("Loading..");

setTimeout(function() {

  $('#SetPriorityModal').fadeOut();  
  $('.editCntnt').removeClass("loader"); 

}, 1000);

$('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text(data.success);
  
  setTimeout(function() {
    $('#MsgModalSucc').fadeOut();
     location.reload();
  }, 1000);
                       
    }
    });

      }
    });


// Delete Task trigger *************** 
    $(".dltTaskOKBtn").on("click", function(e) {
    e.preventDefault();

    var dataString = {
    taskid : $("#delID_inpt").val(),
    };

   $.ajax({
    type: "POST",
    url: "{{ URL::to('delete_task') }}",
    data: dataString,
    dataType: "json",
    cache : false,
    success: function(data){

$('.editCntnt').addClass("loader").text("Loading..");

setTimeout(function() {

  $('#SetPriorityModal').fadeOut();  
  $('.editCntnt').removeClass("loader"); 

}, 1000);

$('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text(data.success);
  
  setTimeout(function() {
    $('#MsgModalSucc').fadeOut();
     location.reload();
  }, 1000);
                       
    }
    });

    });


// Assing Task trigger ***************
$(".AsgnTaskOKBtn").on("click", function(e) {
    e.preventDefault();

if ($('#userAssignee').val() == '') {

  $('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text('select User to do the Task');

} else {
    var dataString = {
    taskid : $("#taskID4ToAsign").val(),
    UserAssigner : $("#UserAssigner").val(),
    userAssignee : $("#userAssignee").val(),
    };

   $.ajax({
    type: "POST",
    url: "{{ URL::to('assign_task') }}",
    data: dataString,
    dataType: "json",
    cache : false,
    success: function(data){

$('.editCntnt').addClass("loader").text("Loading..");

setTimeout(function() {

  $('#asignTaskModal').fadeOut();  
  $('.editCntnt').removeClass("loader"); 

}, 3000);

$('#MsgModalSucc').fadeIn();
$('.MsgPrompt').text(data.success);
  
  setTimeout(function() {
    $('#MsgModalSucc').fadeOut();
     location.reload();
  }, 1000);
                       
    }
    });

      }
    });
</script>
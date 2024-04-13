var AddTaskModal = document.getElementById("AddTaskModal");
$(".taskBtn").on("click", function() {
    AddTaskModal.style.display = "block";
});

$("#cancelPayModal").on("click", function() {
    $('#AddTaskModal').fadeOut();
});

$("#closePayModal").on("click", function() {
    $('#AddTaskModal').fadeOut();
});


$("#closeMsgBtn").on("click", function() {
    $('#MsgModalSucc').fadeOut();
});

$(".closeMsg").on("click", function() {
    $('#MsgModal').fadeOut();
    location.reload();
});


$("#closeErrorMsg").on("click", function() {
    $('#ErrorMsgModal').fadeOut();
});


var SetPriorityModal = document.getElementById("SetPriorityModal");
$(".priorityBtn").on("click", function() {

    var id = $(this).attr('id');

    $('#taskIDinput').val(id);

    SetPriorityModal.style.display = "block";
});

$("#closePriotyModal").on("click", function() {
    $('#SetPriorityModal').fadeOut();
});

$("#cancelPriotyModal").on("click", function() {
    $('#SetPriorityModal').fadeOut();
});


var taskStatusModal = document.getElementById("taskStatusModal");
$(".setStatusBtn").on("click", function() {

    var id = $(this).attr('id');

    $('#taskID4Status').val(id);

    taskStatusModal.style.display = "block";
});

$("#closeStatusModal").on("click", function() {
    $('#taskStatusModal').fadeOut();
});

$("#cancelStatusModal").on("click", function() {
    $('#taskStatusModal').fadeOut();
});



var deleteTaskModal = document.getElementById("deleteTaskModal");
$(".dltTaskBtns").on("click", function() {

    var id = $(this).attr('id');

    $('#delID_inpt').val(id);

    deleteTaskModal.style.display = "block";
});

$("#closeDelTaskModal").on("click", function() {
    $('#deleteTaskModal').fadeOut();
});

$("#cancelDelTaskModal").on("click", function() {
    $('#deleteTaskModal').fadeOut();
});



var asignTaskModal = document.getElementById("asignTaskModal");
$(".assngTskBtn").on("click", function() {

    var id = $(this).attr('id');

    $('#taskID4ToAsign').val(id);

    asignTaskModal.style.display = "block";
});

$("#closeAsgnTaskModal").on("click", function() {
    $('#asignTaskModal').fadeOut();
});

$("#cancelAsgnTaskModal").on("click", function() {
    $('#asignTaskModal').fadeOut();
});
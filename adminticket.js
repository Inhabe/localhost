var timeReload = 0.5;//время в минутах
timeReload = timeReload*60;
var timenow=0;

function isReload()
{
timenow++;
if (timenow>=timeReload) {
timenow=0;
$('#table').bootstrapTable('refresh', {url: '/admin/tickets'});
//console.log("reload");
//document.location.reload();
}
}

function Deauth()
{
  $.ajax({
url: 'admin/deauth',
method: 'POST',
data: {
}
}).success(function (res) {
window.location = "Login.html";
}).error(function ( e ) {
console.log( e );
});
}


var t=setInterval("isReload()",1000);

    function MyEvent(event) {
    event = event || window.event;
     timenow=0;
    }
    document.onclick = MyEvent;//клик
    document.onkeypress = MyEvent;//нажатие клавиш клавиатуры

function GetTickets()
{
  $.ajax({
url: '/admin/tickets',
method: 'GET',
data: {
}
}).success(function (res) {
jsondata = res;
jsondata = jsondata.sort(function(obj1,obj2)
{
if (obj1.date!=obj2.date) {
return obj2.urgency-obj1.urgency;
} else {
return (obj1.date-obj2.date);
}
});

$('#table').bootstrapTable({
    //Assigning data to table
    data: jsondata
});

//console.log(jsondata);

//self.forceUpdate();
}).error(function ( e ) {
console.log( e );
});
}


    $(document).ready(FillerTable);
      function  FillerTable() {
                    GetTickets();
    };

  function Updatecomplete()
  {
    $.ajax({
  url: '/admin/ticket',
  method: 'POST',
  data: {
      id: IdInput.value,
      complete: 1,
  }
}).success(function (res) {
  $('#table').bootstrapTable('refresh', {url: '/admin/tickets'});
}).error(function ( e ) {
  console.log( e );
});
  }


  function countRabbits() {
    for(var i=1; i<=3; i++) {
      alert("Кролик номер " + i);
    }
  }



function GoToUser()
{
window.location = "/";
}


function LoginFunc()
{
  $.ajax({
url: '/admin/auth',
method: 'POST',
data: {
    name:logininp.value,
    password:passinp.value,
}
}).success(function (res) {
window.location = "adminticket.html";
console.log(res);

//self.forceUpdate();
}).error(function ( e ) {
console.log( e );
});
}

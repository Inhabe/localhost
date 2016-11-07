  function countRabbits() {
      alert(Urgency.value);
  }

  function GoToAdmin()
  {
    window.location = "/admin";
  }


  function SubmitTicket()
  {
    $.ajax({
  url: '/ticket',
  method: 'POST',
  data: {
      name: Name.value,
      contacts:Contacts.value,
      text:Textfield.value,
      urgency: Urgency.value,
  }
}).success(function (res) {
  console.log(res);
  Id.value = res.id
  Name.disabled = true;
  Contacts.disabled = true;
  Textfield.disabled = true;
  Urgency.disabled = true;
  refreshbutton.style = "none";
  submitbutton.style = "display:none";
  //self.forceUpdate();
}).error(function ( e ) {
  console.log( e );
});
  }

  function ClearForm()
  {
    Id.value = "";
    Name.disabled = false;
    Name.value = "";
    Contacts.disabled = false;
    Contacts.value = "";
    Textfield.disabled = false;
    Textfield.value = "";
    Urgency.disabled = false;
    Urgency.value = "0";
    refreshbutton.style = "display:none";
    submitbutton.style = "none";
  }

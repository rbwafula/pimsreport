$('document').ready(function(){

  var title = document.querySelector('.navbar-brand');
  var fletter = title.innerHTML.charAt(0);
  title.innerHTML = title.innerHTML.replace(fletter, '<span>'+fletter+'</span>');

  console.log(title);

});
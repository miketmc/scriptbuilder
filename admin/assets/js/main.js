var currcampaign = 0;
var formelements = 0;
var dropdowns = [1];

tinymce.init({
     plugins: "code jbimages",
     width: "100%",
     height: "300",
     toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | link image jbimages | code",
    selector: "#content"
 });

function popCampaigns() {

  $.get('./assets/ajax/get-campaigns.php', function(data) {
    $('#campaigns-list').html(data);
  });

}

function popContent() {
   $.post('./assets/ajax/content-controller.php', {
      mode: 'pop',
      campid: currcampaign
    }, function(data) {
    $('#content-pieces').html(data);
   });
}

function popForms() {
   $.post('./assets/ajax/form-controller.php', {
      mode: 'pop',
      campid: currcampaign
    }, function(data) {
    $('#form-pieces').html(data);
   });
}

function popTabs() {
  $.post('./assets/ajax/tab-controller.php', {
    mode: 'pop',
    campid: currcampaign
  }, function(data) {
     $('#tab-pieces').html(data);
   });


}


function setNavheight() {

  height = $(document).height();
  $('#side-nav').css('height', (height-50)+"px");

}

function readForm() {
  var groups =[];
  var counter = 0;
  $('#element-destination li').not('.option').each(function(index) {

    var type = $(this).data('type');
    var el = $(this).data('formel');
    switch (type) {

      case 'text':
   
      label = $('#form-title-'+el).val();
      variable = $('#form-bind-'+el).val();
      groups[index] = [type, label, variable];


        break;

       case 'divider':
   
      label = $('#form-title-'+el).val();
      groups[index] = [type, label];

       case 'states':
   
      label = $('#form-title-'+el).val();
       variable = $('#form-bind-'+el).val();
      groups[index] = [type, label, variable];


        break;

      case 'drop':

      label = $('#form-title-'+el).val();
      variable = $('#form-bind-'+el).val();
      var opts = "";
      $('.option-con-'+el+' li input').each(function(ctr) {
        opts = opts + $(this).val() + ",";
      });
      opts = opts.slice(0, - 1);
      groups[index] = [type, label, variable, opts];

        break;

      case 'check':

      label = $('#form-title-'+el).val();
      variable = $('#form-bind-'+el).val();
      var opts = "";
      $('.option-con-'+el+' li input').each(function(ctr) {
        opts = opts + $(this).val() + ",";
      });
      opts = opts.slice(0, - 1);
      groups[index] = [type, label, variable, opts];

        break; 

      case 'radio':

      label = $('#form-title-'+el).val();
      variable = $('#form-bind-'+el).val();
      var opts = "";
      $('.option-con-'+el+' li input').each(function(ctr) {
        opts = opts + $(this).val() + ",";
      });
      opts = opts.slice(0, - 1);
      groups[index] = [type, label, variable, opts];


      break;

    }

  });

   return(JSON.stringify(groups));

}

jQuery(document).ready(function($) {



 $('#element-destination').sortable();
/* initialize dashboard */

  popCampaigns();
  $('.campaign').html('None Selected');

/* onLoad functions */

$('#tab-nav li').click(function(event) {
  var index = $(this).index()+1;
  $('.tab').addClass('hidden').removeClass('show');
  $('#tabs div:nth-child('+index+')').addClass('show').removeClass('hidden');
  $('#dash-area li:nth-child('+index+')').addClass('show').removeClass('hidden');
  setNavheight();

});

$('#make-script').click(function(event) {
    var campname = $('#campname').val();
    if (campname.length < 1) { alert('You Must Specify a Campaign Name'); } else {

    $.post('./assets/ajax/create-campaign.php', { cname: campname}, function(data) {
        var results = JSON.parse(data);
        alert(results.error);
        if(results.lastid  ) {
        
          currcampaign = results.lastid;
          $('.campaign').html(campname);
        }
        popCampaigns();
        $('.edit-warning').css('display', 'none');
      });
    }
});

$(document).on('click','.edit', function(event) {

var edit =$(this).data('id');

  $.post('./assets/ajax/load-campaign.php', { campid: edit}, function(data) {
    var results = JSON.parse(data);
    $('.campaign').html(results.CampName);
    currcampaign = results.ID;
    popContent();
    popForms();
    popTabs();
    $('.edit-warning').css('display', 'none');
   });

});

$(document).on('click','.trash', function(event) {

var del =$(this).data('id');

  $.post('./assets/ajax/delete-campaign.php', { campid: del}, function(data) {
    popCampaigns();
   });

});

$('#save-content').click(function(event) {
  var contentmode = "save";
  var contitle = $('#content-title').val();
  var contentbody = tinyMCE.get('content').getContent();
    $.post('./assets/ajax/content-controller.php', { 
    mode: contentmode,
    title: contitle,
    copy: contentbody,
    campid: currcampaign
    }, function(data) {
    popContent();
    alert(data);
   });
});

$(document).on('click','.c-edit', function(event) {

var editid =$(this).data('conid');

  $.post('./assets/ajax/content-controller.php', { 
    mode: 'edit',
    campid: editid
  }, function(data) {
    var results = JSON.parse(data);
    $('#content-title').val(results.Title);
    tinyMCE.get('content').setContent(results.Copy);
   });
});

$(document).on('click','.c-trash', function(event) {

var editid=$(this).data('conid');

  $.post('./assets/ajax/content-controller.php', { 
    mode: 'delete',
    campid: editid
  }, function(data) {
    alert(data);
    popContent();
    $('#content-title').val('');
    tinyMCE.get('content').setContent('');
   });
});

$('.insert-text').click(function(event) {
  var html = '<li data-type="text" id="form-element-'+formelements+'" data-formel="'+formelements+'">';
  html = html + 'Text Input: <span class="label-title" id="elheader-'+formelements+'"></span>';
  html = html + '<img src="./assets/images/trash.gif" class="trash" data-element="'+formelements+'">';
  html = html + '<img src="./assets/images/edit.png" class="properties" data-element="'+formelements+'">';
  html = html + '<div class="edit-properties-'+formelements+' hidden props">';
  html = html + '<h4 id="title-'+formelements+'">Input Label</h4>';
  html = html + '<input type="text" id="form-title-'+formelements+'" class="form-label" data-label="'+formelements+'">';
  html = html + '<h4>Variable Name</h4>';
  html = html + '<input type="text" id="form-bind-'+formelements+'" class="form-bind">';
  html = html + '</div></li>';
  $('#element-destination').append(html);
  formelements++;
    setNavheight();

});

$('.insert-divider').click(function(event) {
  var html = '<li data-type="divider" id="form-element-'+formelements+'" data-formel="'+formelements+'">';
  html = html + 'Divider: <span class="label-title" id="elheader-'+formelements+'"></span>';
  html = html + '<img src="./assets/images/trash.gif" class="trash" data-element="'+formelements+'">';
  html = html + '<img src="./assets/images/edit.png" class="properties" data-element="'+formelements+'">';
  html = html + '<div class="edit-properties-'+formelements+' hidden props">';
  html = html + '<h4 id="title-'+formelements+'">Divider</h4>';
  html = html + '<input type="text" id="form-title-'+formelements+'" class="form-label" data-label="'+formelements+'">';
  html = html + '</div></li>';
  $('#element-destination').append(html);
  formelements++;
    setNavheight();

});


$('.insert-drop').click(function(event) {
  var html = '<li data-type="drop" id="form-element-'+formelements+'" data-formel="'+formelements+'">';
  html = html + 'Drop Down: <span class="label-title" id="elheader-'+formelements+'"></span>';
  html = html + '<img src="./assets/images/trash.gif" class="trash" data-element="'+formelements+'">';
  html = html + '<img src="./assets/images/edit.png" class="properties" data-element="'+formelements+'">';
  html = html + '<div class="edit-properties-'+formelements+' hidden props">';
  html = html + '<h4 id="title-'+formelements+'">Drop Down Label</h4>';
  html = html + '<input type="text" id="form-title-'+formelements+'" class="form-label" data-label="'+formelements+'">';
  html = html + '<h4>Options</h4>';
  html = html + '<div class="options-container">';
  html = html + '<ul id="drop-dop-coptions" class="option-con-'+formelements+'">';
  html = html + '<li class="option"><input type="text"><span class="add-option" data-dropdown="'+formelements+'">+</span></li>';
  html = html + '</ul>';
  html = html + '</div>';
  html = html + '<h4>Variable Name</h4>';
  html = html + '<input type="text" id="form-bind-'+formelements+'" class="form-bind">';
  html = html + '</div></li>';
  $('#element-destination').append(html);
  formelements++;
  setNavheight();

});

$('.insert-check').click(function(event) {
  var html = '<li data-type="check" id="form-element-'+formelements+'" data-formel="'+formelements+'">';
  html = html + 'Check Box(s): <span class="label-title" id="elheader-'+formelements+'"></span>';
  html = html + '<img src="./assets/images/trash.gif" class="trash" data-element="'+formelements+'">';
  html = html + '<img src="./assets/images/edit.png" class="properties" data-element="'+formelements+'">';
  html = html + '<div class="edit-properties-'+formelements+' hidden props">';
  html = html + '<h4 id="title-'+formelements+'">Check Box Label</h4>';
  html = html + '<input type="text" id="form-title-'+formelements+'" class="form-label" data-label="'+formelements+'">';
  html = html + '<h4>Options</h4>';
  html = html + '<div class="options-container">';
  html = html + '<ul id="drop-dop-coptions" class="option-con-'+formelements+'">';
  html = html + '<li class="option"><input type="text"><span class="add-option" data-dropdown="'+formelements+'">+</span></li>';
  html = html + '</ul>';
  html = html + '</div>';
  html = html + '<h4>Variable Name</h4>';
  html = html + '<input type="text" id="form-bind-'+formelements+'" class="form-bind">';
  html = html + '</div></li>';
  $('#element-destination').append(html);
  formelements++;
  setNavheight();
});

$('.insert-radio').click(function(event) {
  var html = '<li data-type="radio" id="form-element-'+formelements+'" data-formel="'+formelements+'">';
  html = html + 'Radio: <span class="label-title" id="elheader-'+formelements+'"></span>';
  html = html + '<img src="./assets/images/trash.gif" class="trash" data-element="'+formelements+'">';
  html = html + '<img src="./assets/images/edit.png" class="properties" data-element="'+formelements+'">';
  html = html + '<div class="edit-properties-'+formelements+' hidden props">';
  html = html + '<h4 id="title-'+formelements+'">Radio Label</h4>';
  html = html + '<input type="text" id="form-title-'+formelements+'" class="form-label" data-label="'+formelements+'">';
  html = html + '<h4>Options</h4>';
  html = html + '<div class="options-container">';
  html = html + '<ul id="drop-dop-coptions" class="option-con-'+formelements+'">';
  html = html + '<li class="option"><input type="text"><span class="add-option" data-dropdown="'+formelements+'">+</span></li>';
  html = html + '</ul>';
  html = html + '</div>';
  html = html + '<h4>Variable Name</h4>';
  html = html + '<input type="text" id="form-bind-'+formelements+'" class="form-bind">';
  html = html + '</div></li>';
  $('#element-destination').append(html);
  formelements++;
  setNavheight();

});

$('.insert-states').click(function(event) {
   var html = '<li data-type="states" id="form-element-'+formelements+'" data-formel="'+formelements+'">';
   html = html + 'States: <span class="label-title" id="elheader-'+formelements+'"></span>';
   html = html + '<img src="./assets/images/trash.gif" class="trash" data-element="'+formelements+'">';
   html = html + '<img src="./assets/images/edit.png" class="properties" data-element="'+formelements+'">';
   html = html + '<div class="edit-properties-'+formelements+' hidden props">';
   html = html + '<h4 id="title-'+formelements+'">States Label</h4>';
   html = html + '<input type="text" id="form-title-'+formelements+'" class="form-label" data-label="'+formelements+'">';
   html = html + '<h4>Variable Name</h4>';
   html = html + '<input type="text" id="form-bind-'+formelements+'" class="form-bind">';
   html = html + '<h4>Variable Name</h4>';
   html = html + '<input type="text" id="form-bind-'+formelements+'" class="form-bind">';
   html = html + '</div></li>';
     $('#element-destination').append(html);
  formelements++;
  setNavheight();
});


$(document).on('click', '.properties', function(event) {
  $('.edit-properties-'+$(this).data('element')).slideToggle(200, function() {
   setNavheight();
   });
});

$(document).on('click', '.trash', function(event) {
  var del = $(this).data('element');
  $('#form-element-'+del).remove();
  formelements--;
});

$(document).on('click', '.add-option', function(event) {
 var which = $(this).data('dropdown');
 html = '<li class="option"><input type="text"><span class="remove-option" data-dropdown="'+which+'">-</span></li>';
 $('.option-con-'+which).append(html);
});


$(document).on('click', '.remove-option', function(event) {
  $(this).parent().remove('');
});


$(document).on('change keyup paste', '.form-label', function(event) {
which = $(this).data('label');
var addtext = $(this).val();
$('#elheader-'+which).html(addtext);
});


$('#save-form').click(function(event) {
  var formname = $('#form-name').val();
  if (formname == "") { alert('You Must Name Your Form!'); } else {
  var formdata = readForm();
  var formmode = "save";
    $.post('./assets/ajax/form-controller.php', { 
    mode: formmode,
    title: formname,
    copy: formdata,
    campid: currcampaign
    }, function(data) {

    alert(data);
    popForms();
   });

  }
});


$(document).on('click','.f-trash', function(event) {

var editid=$(this).data('formid');

  $.post('./assets/ajax/form-controller.php', { 
    mode: 'delete',
    campid: editid
  }, function(data) {
    popForms();
    alert(data);
    
   });
});

$(document).on('click','.f-edit', function(event) {

var editid =$(this).data('formid');

  $.post('./assets/ajax/form-controller.php', { 
    mode: 'edit',
    campid: editid
  }, function(data) {
    
    var results = JSON.parse(data);
    $('#element-destination').html(results.html);
    $('#form-name').val(results.formname);
    formelements = results.eles;

   });
});


$('#add-tab').click(function(event) {
  var html = '';
 
  $.post('./assets/ajax/content-controller.php', {
    mode: 'getlist',
    campid: currcampaign
  }, function(data) {

  html = html + '<tr>';
  html = html + '<td width="250"><input name="tab-title" class="tab-title" placeholder="Tab Title..."></td>';
  html = html + '<td width="250"><select name="content-selection" class="content-selection">'+data+'</select></td>';
  html = html + '<td width="16" class="t-trash"><img src="./assets/images/trash.gif" ></td>';
  html = html + '</tr>';
 
  $('#tab-pieces').append(html);

   });  

});

$(document).on('click', '.t-trash', function(event) {
$(this).parent('tr').remove();

});


$('#save-tabs').click(function(event) {
    var titles = '';
    var ids = '';

   $('.content-selection').each(function(index) {
    ids = ids + $(this).val() + ",";
   });

   $('.tab-title').each(function(index) {
    titles = titles + $(this).val() + ",";
   });

   ids = ids.slice(0, - 1);
   titles = titles.slice(0, - 1);
 

  $.post('./assets/ajax/tab-controller.php', {
    mode: 'save',
    campid: currcampaign,
    names: titles,
    content: ids
  }, function(data) {
      alert(data);
   });

});


});
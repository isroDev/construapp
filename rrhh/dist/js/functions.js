function getConstructions() {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_constructions" },
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function getbusiness() {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_business" },
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function get_Supervisors(const_id) {
    var res;
    $.ajax({
      type: "POST",
      url: "../controllers/controller.php",
      dataType: "JSON",
      async: false,
      data: { action: "get_supervisors", construction: const_id},
      success: function (response) {
        res = response;
        
      },
    });
    return res;
}
function get_Rut_Requesters() {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_Rut_Requesters"},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function get_Rut_Issuers() {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_Rut_Issuers"},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function get_requests_of_user(user_id) {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_requests_of_user", user_id: user_id},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function get_deliveries_List(user_id) {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_deliveries_List", user_id: user_id},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function CheckPassword(password) {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "check_password", password: password},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function get_Materials() {
    var res;
    $.ajax({
      type: "POST",
      url: "../controllers/controller.php",
      dataType: "JSON",
      async: false,
      data: { action: "get_materials"},
      success: function (response) {
        res = response;
        
      },
    });
    return res;
}
function getUser() {
    var res;
    $.ajax({
      type: "POST",
      url: "../controllers/controller.php",
      dataType: "JSON",
      async: false,
      data: { action: "get_user"},
      success: function (response) {
        res = response;
        
      },
    });
    return res;
}
function getRutList() {
    var res;
    $.ajax({
      type: "POST",
      url: "../controllers/controller.php",
      dataType: "JSON",
      async: false,
      data: { action: "get_rut"},
      success: function (response) {
        res = response;
        
      },
    });
    return res;
}
function getSuppliers() {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_suppliers"},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function get_Receipt_Data(receipt_ID) {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_Receipt_Data", receipt_ID: receipt_ID},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function get_Receipts_List() {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_Receipts_List"},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function getParameterFromUrl(name, url) {
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function cancelFullScreen() {
  if (document.cancelFullScreen) {
    document.cancelFullScreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitCancelFullScreen) {
    document.webkitCancelFullScreen();
  } else if (document.msCancelFullScreen) {
    document.msCancelFullScreen();
  }
  link = document.getElementById("container");
  link.removeAttribute("onclick");
  link.setAttribute("onclick", "fullScreen(this)");
}

function fullScreen(element) {
  if (element.requestFullScreen) {
    element.requestFullScreen();
  } else if (element.webkitRequestFullScreen) {
    element.webkitRequestFullScreen();
  } else if (element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  }
  link = document.getElementById("container");
  link.removeAttribute("onclick");
  link.setAttribute("onclick", "cancelFullScreen()");
}
function bs_input_file() {
  $(".input-file").before(function () {
    if (!$(this).prev().hasClass("input-ghost")) {
      var element = $(
        "<input type='file' class='input-ghost' style='visibility:hidden; height:0'>"
      );
      element.attr("name", $(this).attr("name"));
      element.change(function () {
        element
          .next(element)
          .find("input")
          .val(element.val().split("\\").pop());
      });
      $(".btn-choose").on("click", function(){
        element.click();

      });
      $(".btn-reset").on("click", function(){
       $("#documents").val("");

      });
      $(this).find("input").css("cursor", "pointer");
      $(this)
        .find("input")
        .mousedown(function () {
          $(this).parents(".input-file").prev().click();
          return false;
        });
      return element;
    }
  });
}
function getUserById(user_id) {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/controller.php",
    dataType: "JSON",
    async: false,
    data: { action: "getUserById", user_id: user_id},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
function GetWorkers() {
  var res;
  $.ajax({
    type: "POST",
    url: "../controllers/administrator.php",
    dataType: "JSON",
    async: false,
    data: { action: "get_workers"},
    success: function (response) {
      res = response;
      
    },
  });
  return res;
}
$(document).ready(function () {
  var res = getUser();
  if (res["login"] == false) {
    window.location.href = "../index.html";
  }
  if (res["user"]) {

    $("#sidebar_username").text(res["user"]["NAME"]);
    $("#sidebar_user_role").text(res["user"]["USER_ROLE"]);
    $("#user").text(res["user"]["NAME"]);

  }

});
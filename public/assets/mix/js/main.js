window.addEventListener("load", function () {
  // Base URL
  window.baseUrl = window.location.origin;

  // Ajax Setup
  $.ajaxSetup({
    headers: {
      "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
    },
    statusCode: {
      400: function (response) {
        var jsonValue = JSON.parse(response.responseText);
        showAlert(jsonValue.message, "danger");
        $(".loaderButton").hide();
        $(".submitButton").show();
      },
      401: function () {
        // location.reload();
      },
      419: function () {
        // location.reload();
      },
      422: function (response) {
        var jsonValue = JSON.parse(response.responseText);
        Object.keys(jsonValue.errors).forEach((key, value) => {
          $(`.${key}_error`).text(jsonValue.errors[key]);
        });
        $(".loaderButton").hide();
        $(".submitButton").show();
      },
    },
    error: (jqXHR, textStatus, errorThrown) => {
      //showAlert(err.responseText.message, 'danger')
    },
    beforeSend: function () {
      $(".submitBtn").addClass("disabled");
    },
    complete: function () {
      $(".submitBtn").removeClass("disabled");
    },
  });

  // Bootstrap Alert
  window.showAlert = (message, type = "info", closeDelay = 5000) => {
    var $cont = $("#alerts-container");

    if ($cont.length == 0) {
      // alerts-container does not exist, create it
      $cont = $('<div id="alerts-container">').appendTo($("body"));
    }

    // default to alert-info; other options include success, warning, danger
    type = type || "info";

    // create the alert div
    var alert = $("<div>")
      .addClass("alert alertbtn alert-" + type + " alert-dismissible fade show")
      .append(message)
      .append(
        $(
          '<i class="fa-solid fa-x closebutton" data-bs-dismiss="alert" aria-label="Close">'
        )
      );

    // add the alert div to top of alerts-container, use append() to add to bottom
    $cont.prepend(alert);

    // if closeDelay was passed - set a timeout to close the alert
    if (closeDelay)
      window.setTimeout(function () {
        alert.alert("close");
      }, closeDelay);
  };

  window.showSweetAlert = (title, html = "", icon = "success") => {
    Swal.fire({
      title: title,
      html: html,
      icon: icon
    });
  }

  // Confirmation
  $(document).on("click", ".confirmationModal", function () {
    $("#ConfirmModalLabel").text($(this).attr("data-heading"));
    $("#ConfirmText").text($(this).attr("data-text"));
    $("#ConfirmButton").text($(this).attr("data-button"));
    $("#denyButton").text($(this).attr("data-deny"));
    $("#ConfirmForm").attr("action", $(this).attr("data-action"));
    $("#ConfirmForm")
      .find('[name="_method"]')
      .val($(this).attr("data-method") || "post");
    $("#ConfirmModal").modal("show");
  });

  // Ajax pagination
  $(document).on("click", ".pagination a.pagination-link", function (e) {
    e.preventDefault();
    let url = $(this).attr("href");
    $.get(url, function (data, status) {
      if (status == "success") {
        $("#content").html(data);
        initializeLazyLoading(); // Reinitialize lazy loading for new images
        history.pushState({}, "", url);
        $(".submitButton").show();
        $(".loaderButton").hide();
      } else {
        showAlert("{{ __('messages.error') }}", "danger");
      }
    });
  });

  // Handle page change when a page is selected from the dropdown
  $(document).on(
    "change",
    ".pagination select#pagination-select",
    function (e) {
      e.preventDefault();
      let url = $(this).val();
      $.get(url, function (data, status) {
        if (status == "success") {
          $("#content").html(data);
          initializeLazyLoading(); // Reinitialize lazy loading for new images
          history.pushState({}, "", url);
          $(".submitButton").show();
          $(".loaderButton").hide();
        } else {
          showAlert("{{ __('messages.error') }}", "danger");
        }
      });
    }
  );

  // Image Lazy Load
  window.initializeLazyLoading = () => {
    document
      .querySelectorAll(".lazy-load:not(.loaded)")
      .forEach(function (imgElement) {
        const dataSource = imgElement.getAttribute("data-source");
        if (dataSource) {
          const tempImage = new Image(); // Preload the actual image
          tempImage.src = dataSource;
          tempImage.onload = function () {
            imgElement.src = dataSource; // Replace the src once the image is fully loaded
            imgElement.classList.add("loaded"); // Optionally add a class for CSS transitions
          };
        }
      });
  };
  initializeLazyLoading();

  //summer note
  window.summernoteInit = () => {
    $(".summernote").each((i, ele) => {
      summernoteElementInit(ele);
    });
  };
  window.summernoteElementInit = (element) => {
    $(element).summernote({
      height: $(element).attr("data-height") || "350px",
      dialogsInBody: true,
      airMode: false,
      tooltip: false,
      fontSizes: [
        "8",
        "9",
        "10",
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "18",
        "24",
        "36",
        "48",
        "64",
        "72",
      ],
      lineHeights: [
        "0.2",
        "0.3",
        "0.4",
        "0.5",
        "0.6",
        "0.8",
        "1.0",
        "1.2",
        "1.4",
        "1.5",
        "2.0",
        "3.0",
      ],
      //fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Roboto', 'Segoe UI', 'Segoe UI Symbol', 'Tahoma', 'Times New Roman', 'Verdana'],
      //fontNamesIgnoreCheck: ['Roboto'],
      toolbar: [
        ["edit", ["undo", "redo"]],
        ["headline", ["style"]],
        ["style", ["bold", "italic", "underline", "clear"]],
        //['fontface', ['fontname']],
        ["textsize", ["fontsize"]],
        ["fontclr", ["color"]],
        ["alignment", ["paragraph", "lineheight"]],
        ["insert", ["ul", "ol", "link", "picture"]],
        ["view", ["fullscreen", "codeview"]],
      ],
      popover: {
        link: [],
        air: [],
        image: [
          [
            "image",
            ["resizeFull", "resizeHalf", "resizeQuarter", "resizeNone"],
          ],
          ["float", ["floatLeft", "floatRight", "floatNone"]],
          ["remove", ["removeMedia"]],
        ],
      },
      callbacks: {
        onImageUpload: function (files) {
          editorUploadFiles(files[0], element);
        },
        onMediaDelete: function (files) {
          // to delete the file instantly from the server
          // editorDeleteFile(files[0]);
          // to store the files in an array and delete them when form submitted
          editorFilesStoreToDeleteLater(files[0]);
        },
      },
    });
  };
  // summernoteInit()
  function editorUploadFiles(file, editor) {
    let formData = new FormData();
    formData.append("file", file);
    $.ajax({
      url: baseUrl + "/admin/editor-image-upload",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success) {
          $(editor).summernote("insertImage", res.url);
        } else {
          showAlert("Unable to upload the image", "danger");
        }
      },
      error: function () {
        showAlert("Unable to upload the image", "danger");
      },
      beforeSend: () => {
        $(".submitButton").show();
        $(".loaderButton").hide();
      },
    });
  }

  //delete the file instantly
  function editorDeleteFile(file) {
    let formData = new FormData();
    formData.append("src", file.src);
    $.ajax({
      url: baseUrl + "/admin/editor-image-delete",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
        console.log(res);
      },
      error: function () {
        showAlert("Unable to delete the image", "danger");
      },
      beforeSend: () => {
        $(".submitButton").show();
        $(".loaderButton").hide();
      },
    });
  }

  function editorFilesStoreToDeleteLater(file) {
    let fileSrc = file.src;
    $("body").append(
      `<input type="hidden" name="summernoteDeleteFiles[]" value="${fileSrc}">`
    );
  }

  window.deleteSummernoteFiles = async () => {
    let files = $('input[name="summernoteDeleteFiles[]"]');
    let formData = new FormData();
    files.each(function () {
      formData.append("summernoteDeleteFiles[]", $(this).val());
    });
    return new Promise((resolve, reject) => {
      $.ajax({
        url: baseUrl + "/admin/editor-image-delete",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
          console.log(res);
        },
        complete: function () {
          resolve(true);
        },
      });
    });
  };

  $(".largeView").on("click", function (e) {
    $("#largerImgModalHeading").html($(this).data("name"));
    $("#largerImgModalImage").attr("src", $(this).attr("src"));
    $("#largerImgView").modal("show");
  });

  // $(function () {
  //   $('[data-toggle="tooltip"]').tooltip();
  // });

  window.showValidationError = (errors, scroll = true) => {
    if (errors) {
      Object.keys(errors).forEach((key) => {
        $(`.${key}_error`).text(errors[key]);
      });
      if (scroll) {
        $("html, body").animate(
          {
            scrollTop: $('[name="' + Object.keys(errors)[0] + '"]').length
              ? $('[name="' + Object.keys(errors)[0] + '"]').offset().top - 200
              : 100,
          },
          50
        );
      }
    }
  };

  window.showToast = (title = '', html = '', icon = 'success', position = 'top-end', timer = 5000) => {
    Swal.fire({
      toast: true,
      title,
      html,
      icon,
      position,
      showConfirmButton: false,
      timer,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
        toast.addEventListener('click', () => {
          Swal.close(); 
        });
      }
    });
  };
});

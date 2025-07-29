/* ====== Index ======

1. SCROLLBAR SIDEBAR
2. BACKDROP
3. SIDEBAR MENU
4. SIDEBAR TOGGLE FOR MOBILE
5. SIDEBAR TOGGLE FOR VARIOUS SIDEBAR LAYOUT
6. TODO LIST
7. RIGHT SIDEBAR

====== End ======*/
//import NProgress from plugins/nprogress;
// resources/js/app.js

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'bootstrap';
import 'datatables.net';
import 'datatables.net-bs4';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import moment from 'moment';
import 'daterangepicker';
import 'daterangepicker/daterangepicker.css';
import 'nprogress/nprogress.css';
import NProgress from 'nprogress';
import Chart from 'chart.js/auto';
window.toastr = toastr;
window.moment = moment;
window.Chart = Chart;
window.NProgress = NProgress;

$(document).ready(function () {
    // When "Delete" is clicked, update the form action dynamically
    $('[data-toggle="modal"][data-target="#deleteModal"]').click(function() {
        const categoryId = $(this).data('cat-id');
        const deleteUrl = `/category/${categoryId}`;

        // Update the form action
        $('#dynamicDeleteForm').attr('action', deleteUrl);
    });
  "use strict";

  // Initialize DataTable
  $('#expendable-data-table').DataTable({
    order: [[1, 'desc']],
    "paging": false,   // ❌ pagination removed
    "info": false,
    "searching": true
  });

  /*======== TOASTER ========*/
  function callToaster(positionClass) {
    var name = document.getElementById("user");
    if (name) {
      var user = name.textContent;
      if (document.getElementById("toaster")) {
        toastr.options = {
          closeButton: true,
          debug: false,
          newestOnTop: false,
          progressBar: true,
          positionClass: positionClass,
          preventDuplicates: false,
          onclick: null,
          showDuration: "300",
          hideDuration: "1000",
          timeOut: "5000",
          extendedTimeOut: "1000",
          showEasing: "swing",
          hideEasing: "linear",
          showMethod: "fadeIn",
          hideMethod: "fadeOut"
        };
        toastr.success("Welcome to ToDo App", "Welcome " + user + "!");
      }
    }
  }

  if (document.dir != "rtl") {
    callToaster("toast-top-right");
  } else {
    callToaster("toast-top-left");
  }

  /*======== CIRCLE PROGRESS ========*/
  var gray = '#f5f6fa';
  var circle = $('.circle');
  if (circle.length !== 0) {
    circle.circleProgress({
      lineCap: "round",
      startAngle: 4.8,
      emptyFill: [gray]
    });
  }

  // Format function for DataTable details
  function format(description) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
      '<tr>' +
      '<td>Task description:</td>' +
      '<td>' + description + '</td>' +
      '</tr>' +
      '</table>';
  }



  // DataTable expandable rows functionality
  $('#expendable-data-table tbody').on('click', 'td.details-control', function () {
    var table = $('#expendable-data-table').DataTable();
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var taskDescription = tr.data('description');

    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
    } else {
      row.child(format(taskDescription)).show();
      tr.addClass('shown');
    }
  });

  // Additional error handling for forms
  $('form').on('submit', function(e) {
    var form = $(this);
    var submitBtn = form.find('button[type="submit"], input[type="submit"]');

    // Disable submit button to prevent double submission
    submitBtn.prop('disabled', true);

    // Re-enable after a short delay in case of validation errors
    setTimeout(function() {
      submitBtn.prop('disabled', false);
    }, 2000);
  });

  // Handle AJAX errors globally
  $(document).ajaxError(function(event, xhr, settings, thrownError) {
    console.error('AJAX Error:', thrownError);
    toastr.error('An error occurred. Please try again.', 'Error');
  });

});


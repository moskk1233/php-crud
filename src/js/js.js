const Toast = Swal.mixin({
  toast: true,
  position: "bottom-start",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  },
});

function fetchStudents(page, scrollToTop = false) {
  currentPage = page;
  $("#loading-student").show();
  $.ajax({
    url: "api/student.php",
    method: "GET",
    cache: true,
    data: {
      page: page,
    },
    success: async function (response) {
      const students = response["students"];
      const totalPage = response["total_page"];
      
      updateStudentTable(students);
      updatePagination(totalPage, page);
      
      if (scrollToTop) {
        scrollToTableTop();
      }
    },
    complete: function() {
      $("#loading-student").hide();
    }
  });
}

function updateStudentTable(students) {
  const studentTableBody = $("#student-table tbody");
  studentTableBody.empty();

  students.forEach((student) => {
    studentTableBody.append(`
      <tr>
        <td>${student.id}</td>
        <td>${student.prefix}</td>
        <td>${student.first_name}</td>
        <td>${student.last_name}</td>
        <td>${student.year}</td>
        <td>${student.gpa}</td>
        <td>${student.birthdate}</td>
        <td>
          <a
            href="edit.php?id=${student.id}"
            class="btn btn-primary">
            แก้ไข
          </a>
          <button
            class="btn btn-outline-danger"
            onclick="deleteStudent(${student.id}, ${currentPage})"
          >
            ลบ
          </button>
        </td>
      </tr>
    `);
  });
}

function updatePagination(totalPage, currentPage) {
  const pagination = $("#pagination");
  pagination.empty();

  for (let i = 1; i <= totalPage; i++) {
    const activeClass = i === currentPage ? "active" : "";
    const pageItem = `
      <li class="page-item ${activeClass}">
        <button class="page-link" onclick="fetchStudents(${i}, true)">${i}</button>
      </li>
    `;
    pagination.append(pageItem);
  }
}

function scrollToTableTop() {
  const OFFSET = 100;

  $("html, body").animate(
    {
      scrollTop: $("#student-table").offset().top - OFFSET,
    },
    500
  );
}

async function deleteStudent(id, currentPage) {
  const result = await Swal.fire({
    titleText: "กดยืนยันอีกครั้งเพื่อลบ",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  });

  if (result.isConfirmed) {
    $.ajax({
      url: `api/student.php?id=${id}`,
      method: "DELETE",
      success: async function (response) {
        Toast.fire({
          text: "ลบสำเร็จ",
          icon: "success",
        });
        fetchStudents(currentPage);
      },
      error: function (error) {
        Toast.fire({
          titleText: "เกิดข้อผิดพลาด",
          text: "ไม่สามารถลบนักเรียนได้",
          icon: "error",
        });
      },
    });
  }
}

let currentPage = 1;

$(document).ready(function () {
  fetchStudents(currentPage);
});

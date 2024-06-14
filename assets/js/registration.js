// registration.js

document.getElementById('faculty').addEventListener('change', function () {
    const faculty = this.value;
    const courseSelect = document.getElementById('course');

    // Clear current course options
    courseSelect.innerHTML = '<option value="">Select Course</option>';

    // Populate courses based on selected faculty
    const courses = {
        'FAKULTI PENGURUSAN DAN MUAMALAH': [
            'PB01 Pengurusan', 'PB02 Perakaunan', 'MG01 Pentadbiran Perniagaan (Muamalah)',
            'MT10 Pengurusan Sumber Manusia', 'MT11 Ekonomi', 'MT12 Kewangan Islam',
            'MT13 Perakaunan', 'BB01 Pentadbiran Perniagaan dengan E-Dagang (Kepujian)',
            'BB02 Pengurusan Sumber Insan (Kepujian)', 'BB03 Ekonomi dan Kewangan (Kepujian)',
            'BB04 Perakaunan (Kepujian)', 'BB05 Kewangan Islam (Perbankan) (Kepujian)',
            'BB08 Pengurusan (Industri Halal) (Kepujian)', 'MS31 Perakaunan',
            'MS32 Pengurusan Perniagaan', 'MS33 Perbankan Islam', 'MS34 Pengurusan Sumber Manusia',
            'EB01 Pengurusan Masjid'
        ],
        'FAKULTI PENGAJIAN PERADABAN ISLAM': [
            'PI01 Islamiyyat', 'PI02 Pengajian Bahasa Arab', 'MT05 Usuluddin (Perbandingan Agama)',
            'MT06 Pengajian Al-Hadis', 'MT07 Pengajian Al-Quran', 'MT08 Pengajian Ilmu Qiraat',
            'MT09 Dakwah dan Pembangunan Komuniti', 'MT22 Bahasa Arab untuk Tujuan Khusus',
            'BI02 Al-Quran dan Al-Sunnah dengan Komunikasi (Kepujian)', 'BI03 Usuluddin dengan Multimedia (Kepujian)',
            'BI04 Al-Quran dan Al-Qiraat (Kepujian)', 'BI05 Dakwah dengan Pengurusan Sumber Insan (Kepujian)',
            'BI06 Pengajian Islam (Bahasa Arab dengan Multimedia) (Kepujian)', 'BC01 Pengajian Bahasa Al-Quran (Kepujian)',
            'BC03 Pengajian Islam (Bahasa Arab Terjemahan) (Kepujian)', 'IS11 Pengajian Bahasa Al-Quran',
            'IS13 Akidah dan Pemikiran Islam', 'IS14 Al-Quran dan Al-Sunnah', 'IS15 Dakwah',
            'IS16 Tahfiz Al-Quran dan Al-Qiraat', 'FA01 Asasi Pengajian Islam'
        ],
        'FAKULTI MULTIMEDIA KREATIF DAN KOMPUTERAN': [
            'PT02 Teknologi Maklumat', 'MC03 Teknologi Maklumat', 'MT20 Sains (Multimedia Kreatif)',
            'MT23 Sains Teknologi Maklumat', 'BT01 Multimedia Kreatif (Media Interaktif) (Kepujian)',
            'BT02 Teknologi Maklumat (Teknologi Rangkaian) (Kepujian)', 'BT04 Multimedia Kreatif (Rekabentuk Digital) (kepujian)',
            'BT05 Sistem Maklumat (Kepujian)', 'MS36 Multimedia', 'MS39 Sains Komputer', 'FA03 Pengajian Asas Teknologi Maklumat'
        ],
        'FAKULTI PENDIDIKAN': [
            'PE01 Pendidikan', 'MT15 Pendidikan (Pendidikan Islam)', 'MT16 Pendidikan (Pendidikan Bahasa)',
            'MT17 Pendidikan (Kurikulum & Pedagogi)', 'MT18 Pendidikan (Pentadbiran Pendidikan)', 'MT19 Pendidikan (Teknologi Pendidikan)',
            'BE01 Perguruan (Kepujian) Pengajaran Bahasa Inggeris sebagai Bahasa Kedua (TESL) dengan Multimedia',
            'BE02 Pendidikan Islam dengan Multimedia (Kepujian)', 'BE03 Pendidikan dengan Kepujian (Pendidikan Tahfiz Al-Quran & Al-Qiraat)',
            'ES52 Perguruan (TESL)', 'ES53 Perguruan (Pendidikan Islam)'
        ],
        'FAKULTI SYARIAH DAN UNDANG-UNDANG': [
            'MG02 Syariah (Pengurusan)', 'MT21 Undang-undang Syariah', 'BS03 Syariah dan Undang-undang (Kepujian)',
            'BS02 Syariah dengan Muamalat (Kepujian)', 'IS12 Pengajian Syariah', 'IS18 Syariah dan Perundangan Islam',
            'ES01 Pengurusan Zakat'
        ],
        'FAKULTI SAINS SOSIAL': [
            'MT14 Komunikasi', 'BC02 Komunikasi (Penyiaran) (Kepujian)', 'BB09 Bahasa Inggeris (Kepujian) dengan Komunikasi Korporat',
            'CS41 Komunikasi', 'LS43 Pengajian Bahasa Inggeris', 'FA05 Asasi Komunikasi', 'FA06 Asasi Bahasa Inggeris'
        ],
        'INSTITUT KAJIAN HADIS & AKIDAH': [
            'MT04 Usuluddin dan Pemikiran Islam'
        ],
        'PUSAT MATRIKULASI': [
            'FA01 Asasi Pengajian Islam', 'FA02 Asasi Pengurusan', 'FA03 Pengajian Asas Teknologi Maklumat',
            'FA04 Asasi Bahasa Arab', 'FA05 Asasi Komunikasi', 'FA06 Asasi Bahasa Inggeris'
        ]
    };

    if (courses[faculty]) {
        courses[faculty].forEach(course => {
            const option = document.createElement('option');
            option.value = course;
            option.textContent = course;
            courseSelect.appendChild(option);
        });
    }
});

function validateForm() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const icNo = document.getElementById('ic_no').value;
    const birthDate = document.getElementById('birth_date').value;
    const faculty = document.getElementById('faculty').value;
    const course = document.getElementById('course').value;

    if (!username || !email || !password || !confirmPassword || !icNo || !birthDate || !faculty || !course) {
        alert('All fields are required.');
        return false;
    }

    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        return false;
    }

    if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[\W_]/.test(password)) {
        alert('Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.');
        return false;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return false;
    }

    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('program-registration-form');
  
    form.addEventListener('submit', function(event) {
      event.preventDefault();
  
      const formData = new FormData(form);
      formData.append('action', 'program_registration');
  
      fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(response => {
        if (response.success) {
          Swal.fire({
            title: 'Success',
            text: response.message,
            icon: 'success'
          }).then(function() {
            window.location.href = '/';
          });
        } else {
          Swal.fire({
            title: 'Error',
            text: response.message,
            icon: 'error'
        }).then(function() {
            history.back();
          });
        }
      })
      .catch(error => {
        Swal.fire({
          title: 'Error',
          text: 'An error occurred while submitting your registration.',
          icon: 'error'
        }).then(function() {
            history.back();
          });
      });
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('volunteer-registration-form');
  
    form.addEventListener('submit', function(event) {
      event.preventDefault();
  
      const formData = new FormData(form);
      formData.append('action', 'volunteer_registration');
  
      fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(response => {
        if (response.success) {
          Swal.fire({
            title: 'Success',
            text: response.message,
            icon: 'success'
          }).then(function() {
            history.back();
          });
        } else {
          Swal.fire({
            title: 'Error',
            text: response.message,
            icon: 'error'
        }).then(function() {
            history.back();
          });
        }
      })
      .catch(error => {
        Swal.fire({
          title: 'Error',
          text: 'An error occurred while submitting your registration.',
          icon: 'error'
        }).then(function() {
            history.back();
          });
      });
    });
  });
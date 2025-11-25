<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Evaluation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #eef2f7; }
        .card-style { background: #ffffff; border-radius: 14px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        .section-title { font-size: 1.25rem; font-weight: 600; color: #0d6efd; border-left: 4px solid #0d6efd; padding-left: 10px; margin-bottom: 20px; }
        .question-title { font-weight: 600; margin-bottom: 10px; }
        .required-icon { color: red; font-weight: bold; margin-left: 5px; }
        .page { display: none; }
        .page.active { display: block; }

        .custom-radio-option {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 18px; margin: 5px;
            background: #f7f9fc; border: 2px solid #d0d7e2;
            border-radius: 12px; cursor: pointer;
            transition: all 0.2s ease; font-weight: 500; user-select: none;
        }
        .custom-radio-option:hover { background: #eef4ff; border-color: #0d6efd; transform: translateY(-2px); }
        .custom-radio-option input[type="radio"] { accent-color: #0d6efd; width: 18px; height: 18px; }
        .custom-radio-option.active { background: #e6f0ff; border-color: #0d6efd; box-shadow: 0 0 10px rgba(13,110,253,0.3); }
    </style>
</head>

<body>

<div class="container py-5">

    <div class="card-style">

        <h3 class="text-center mb-4">Teacher Evaluation Form</h3>

        <!-- FORM MULAI -->
        <form action="{{route('penilaianStore')}}" method="POST">
            @csrf

            <!-- Hidden input sesuai tabel -->
            <input type="hidden"  name="siswa_id" value="{{ auth()->user()->siswa->id }}">
            <input type="hidden"  name="guru_id" value="{{ request('guru_id') }}">
            <input type="hidden"  name="kelas" value="{{ auth()->user()->siswa->kelas }}">
            <input type="hidden"  name="unit" value="{{ auth()->user()->siswa->unit->nama }}">
            <input type="hidden"  name="tanggal_isi" value="{{ date('Y-m-d') }}">
            <input type="hidden"  name="waktu_isi" value="{{ date('H:i:s') }}">

            <!-- ====================== PAGE 1 ====================== -->
            <div id="page1" class="page active">


                <!-- Q1 -->
                <div class="mb-4">
                    <div class="question-title">1. He/she can explain the lesson well in English. <span class="required-icon">*</span></div>
                    <div class="d-flex flex-wrap">
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan1" required value="1"> 1 Never</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan1" value="2"> 2 Rarely</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan1" value="3"> 3 Sometimes</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan1" value="4"> 4 Often</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan1" value="5"> 5 Always</label>
                    </div>
                </div>

                <!-- Q2 -->
                <div class="mb-4">
                    <div class="question-title">2. He/she speaks English with me and other students in class. <span class="required-icon">*</span></div>
                    <div class="d-flex flex-wrap">
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan2" required value="1"> 1 Never</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan2" value="2"> 2 Rarely</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan2" value="3"> 3 Sometimes</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan2" value="4"> 4 Often</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan2" value="5"> 5 Always</label>
                    </div>
                </div>

                <!-- Q3 -->
                <div class="mb-4">
                    <div class="question-title">3. He/she speaks English with other teachers. <span class="required-icon">*</span></div>
                    <div class="d-flex flex-wrap">
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan3" required value="1"> 1 Never</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan3" value="2"> 2 Rarely</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan3" value="3"> 3 Sometimes</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan3" value="4"> 4 Often</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan3" value="5"> 5 Always</label>
                    </div>
                </div>

                <!-- Q4 -->
                <div class="mb-4">
                    <div class="question-title">4. I understand when he/she explains in English. <span class="required-icon">*</span></div>
                    <div class="d-flex flex-wrap">
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan4" required value="1"> Strongly disagree</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan4" value="2"> Disagree</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan4" value="3"> Agree</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan4" value="4"> Strongly agree</label>
                    </div>
                </div>

                <button type="button" class="btn btn-primary w-100 mt-4" onclick="nextPage()">Next →</button>

            </div>

            <!-- ====================== PAGE 2 ====================== -->
            <div id="page2" class="page">

                <!-- Q5 -->
                <div class="mb-4">
                    <div class="question-title">5. I speak English with my friends in class. <span class="required-icon">*</span></div>
                    <div class="d-flex flex-wrap">
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan5" required value="1"> 1 Never</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan5" value="2"> 2 Rarely</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan5" value="3"> 3 Sometimes</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan5" value="4"> 4 Often</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan5" value="5"> 5 Always</label>
                    </div>
                </div>

                <!-- Q6 -->
                <div class="mb-4">
                    <div class="question-title">6. I speak English outside the classroom. <span class="required-icon">*</span></div>
                    <div class="d-flex flex-wrap">
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan6" required value="1"> 1 Never</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan6" value="2"> 2 Rarely</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan6" value="3"> 3 Sometimes</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan6" value="4"> 4 Often</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan6" value="5"> 5 Always</label>
                    </div>
                </div>

                <!-- Q7 -->
                <div class="mb-4">
                    <div class="question-title">7. I feel confident speaking English at school. <span class="required-icon">*</span></div>
                    <div class="d-flex flex-wrap">
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan7" required value="1"> Strongly disagree</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan7" value="2"> Disagree</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan7" value="3"> Agree</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan7" value="4"> Strongly agree</label>
                    </div>
                </div>

                <!-- Q8 -->
                <div class="mb-4">
                    <div class="question-title">8. My English has improved because I am a DCS student. <span class="required-icon">*</span></div>
                    <div class="d-flex flex-wrap">
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan8" required value="1"> Strongly disagree</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan8" value="2"> Disagree</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan8" value="3"> Agree</label>
                        <label class="custom-radio-option"><input type="radio" name="pertanyaan8" value="4"> Strongly agree</label>
                    </div>
                </div>

                <!-- Q9 -->
                <div class="mb-4">
                    <div class="question-title">9. Do you have ideas to improve English-speaking environment?</div>
                    <textarea name="pertanyaan9" class="form-control" rows="3" placeholder="Write your suggestion..."></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="prevPage()">← Back</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

            </div>

        </form>
        <!-- FORM END -->

    </div>
</div>


<!-- JS -->
<script>
function nextPage() {
    document.getElementById("page1").classList.remove("active");
    document.getElementById("page2").classList.add("active");
}
function prevPage() {
    document.getElementById("page2").classList.remove("active");
    document.getElementById("page1").classList.add("active");
}

// highlight option
document.querySelectorAll('.custom-radio-option input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const group = document.querySelectorAll(`input[name="${this.name}"]`);
        group.forEach(r => r.parentElement.classList.remove('active'));
        this.parentElement.classList.add('active');
    });
});
</script>

</body>
</html>

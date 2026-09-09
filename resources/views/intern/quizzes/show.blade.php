@extends('layouts.intern')

@section('title', 'Kuis: ' . $quiz->title)

@section('content')

<div class="max-w-4xl mx-auto space-y-6 pb-16">

    {{-- Back to Module --}}
    <div>
        <a href="{{ route('intern.modules.show', $quiz->module_id) }}"
           class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition">

            <svg class="w-4 h-4"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 19l-7-7 7-7"/>

            </svg>

            Kembali ke Modul {{ $quiz->module->order }}

        </a>
    </div>


    {{-- Quiz Header --}}
    <div class="bg-navy-luxury p-6 sm:p-8 rounded-2xl border border-gold-subtle text-white shadow-xl space-y-2">

        <div class="flex items-center justify-between">

            <span class="px-3 py-1 rounded-full bg-gold-accent/10 border border-gold-subtle text-gold-accent text-[10px] font-semibold tracking-widest uppercase">
                EVALUASI PEMAHAMAN
            </span>

            <span class="text-xs text-amber-200/90 font-medium bg-amber-950/40 px-3 py-1 rounded-lg border border-amber-500/20">
                KKM: {{ $quiz->passing_score ?? 70 }}%
            </span>

        </div>


        <h1 class="font-serif-luxury text-xl sm:text-2xl font-bold text-amber-50">
            {{ $quiz->title }}
        </h1>


        <p class="text-xs text-slate-300 font-light">
            Pilihlah salah satu jawaban yang paling tepat pada setiap soal.
        </p>

    </div>


    {{-- Question Navigation --}}
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">

        <div class="flex items-center justify-between text-xs">

            <span class="font-bold text-slate-700 uppercase tracking-wider">
                Soal
            </span>


            <span id="answered-count-text"
                  class="font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200/60">

                Terjawab: 0 / {{ $quiz->questions->count() }}

            </span>

        </div>


        <div
            class="flex flex-wrap gap-2 pt-1"
            id="question-nav-container"
            data-total-questions="{{ $quiz->questions->count() }}"
        >

            @foreach($quiz->questions as $index => $q)

                <button
                    type="button"
                    data-question-index="{{ $index }}"
                    id="nav-btn-{{ $index }}"
                    class="w-9 h-9 rounded-xl font-bold text-xs border transition-all duration-200 flex items-center justify-center bg-slate-100 border-slate-200 text-slate-600 hover:bg-slate-200"
                >

                    {{ $index + 1 }}

                </button>

            @endforeach

        </div>

    </div>


    {{-- Quiz Form --}}
    <form
        id="quizForm"
        action="{{ route('intern.quizzes.submit', $quiz->id) }}"
        method="POST"
    >

        @csrf


        @forelse($quiz->questions as $index => $question)

            {{-- Question --}}
            <div
                class="question-step hidden bg-white p-7 sm:p-9 rounded-2xl border border-slate-200/80 shadow-sm space-y-6"
                id="question-step-{{ $index }}"
            >

                {{-- Question Title --}}
                <div class="flex items-start gap-4">

                    <span class="w-8 h-8 rounded-xl bg-amber-500/10 border border-gold-subtle text-gold-accent font-bold text-xs sm:text-sm flex items-center justify-center flex-shrink-0 mt-0.5">

                        {{ $index + 1 }}

                    </span>


                    <h2 class="text-base sm:text-lg font-semibold text-slate-900 leading-relaxed pt-0.5">

                        {{ $question->question }}

                    </h2>

                </div>


                {{-- Answer Options --}}
                @php

                    $options = [
                        'a' => $question->option_a,
                        'b' => $question->option_b,
                        'c' => $question->option_c,
                        'd' => $question->option_d,
                    ];

                @endphp


                <div class="space-y-3 pt-1 sm:pl-12">

                    @foreach($options as $key => $optionText)

                        @if(!empty($optionText))

                            <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-amber-400 hover:bg-amber-50/40 cursor-pointer transition-all duration-200 select-none group">

                                <input
                                    type="radio"
                                    name="answers[{{ $question->id }}]"
                                    value="{{ $key }}"
                                    class="w-4.5 h-4.5 text-amber-600 focus:ring-amber-500 border-slate-300 flex-shrink-0"
                                >


                                <div class="flex items-center gap-3 text-sm text-slate-700 font-medium group-hover:text-slate-900 leading-relaxed">

                                    <span class="w-6 h-6 rounded-md bg-slate-100 group-hover:bg-amber-200/70 text-slate-600 group-hover:text-amber-950 uppercase font-bold text-xs flex items-center justify-center flex-shrink-0 transition">

                                        {{ $key }}

                                    </span>


                                    <span>
                                        {{ $optionText }}
                                    </span>

                                </div>

                            </label>

                        @endif

                    @endforeach

                </div>

            </div>

        @empty

            <div class="p-10 text-center bg-white rounded-2xl border border-slate-200 text-slate-500 text-sm">

                Belum ada soal yang tersedia untuk kuis ini.

            </div>

        @endforelse


        {{-- Quiz Navigation --}}
        @if($quiz->questions->count() > 0)

            <div class="flex items-center justify-between pt-4">

                {{-- Previous --}}
                <button
                    type="button"
                    id="prev-btn"
                    onclick="prevQuestion()"
                    class="px-6 py-3 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition duration-200 shadow-sm"
                >

                    &larr; Sebelumnya

                </button>


                {{-- Next --}}
                <button
                    type="button"
                    id="next-btn"
                    onclick="nextQuestion()"
                    class="px-6 py-3 rounded-xl bg-navy-luxury hover:bg-slate-800 text-white font-bold text-xs transition duration-200 shadow-md"
                >

                    Selanjutnya &rarr;

                </button>


                {{-- Submit --}}
                <button
                    type="button"
                    id="submit-trigger-btn"
                    onclick="openConfirmModal()"
                    class="hidden px-8 py-3.5 bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs rounded-xl shadow-lg transition duration-200"
                >

                    Kirim Jawaban Kuis &rarr;

                </button>

            </div>

        @endif

    </form>

</div>



{{-- ========================================================= --}}
{{-- CONFIRMATION MODAL --}}
{{-- ========================================================= --}}

<div
    id="confirmModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-fade-in"
>

    <div class="bg-white rounded-2xl shadow-2xl border border-slate-100 max-w-md w-full p-6 text-center space-y-5 transform transition-all scale-100">


        {{-- Modal Icon --}}
        <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto border-4 border-amber-50">

            <svg
                class="w-7 h-7"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />

            </svg>

        </div>


        {{-- Modal Text --}}
        <div class="space-y-2">

            <h3 class="text-lg font-bold text-slate-900">

                Konfirmasi Kumpulkan Kuis

            </h3>


            <p
                class="text-xs text-slate-600 leading-relaxed"
                id="modal-summary-text"
            >

                Apakah Anda yakin ingin mengumpulkan kuis ini?

            </p>

        </div>


        {{-- Modal Buttons --}}
        <div class="flex items-center gap-3 pt-2">

            <button
                type="button"
                onclick="closeConfirmModal()"
                class="w-1/2 py-3 px-4 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-100 transition"
            >

                Periksa Lagi

            </button>


            <button
                type="button"
                onclick="submitQuiz()"
                class="w-1/2 py-3 px-4 rounded-xl bg-navy-luxury hover:bg-gold-accent text-white hover:text-slate-950 font-bold text-xs shadow-md transition"
            >

                Ya, Kirim Sekarang

            </button>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

    let currentStep = 0;


    const questionNavContainer =
        document.getElementById('question-nav-container');


    const totalQuestions =
        Number(questionNavContainer.dataset.totalQuestions);



    /*
    |--------------------------------------------------------------------------
    | Show Question
    |--------------------------------------------------------------------------
    */

    function showQuestion(index) {

        // Sembunyikan seluruh soal
        document
            .querySelectorAll('.question-step')
            .forEach(el => {

                el.classList.add('hidden');

            });


        // Tampilkan soal yang dipilih
        const activeStep =
            document.getElementById(`question-step-${index}`);


        if (activeStep) {

            activeStep.classList.remove('hidden');

        }


        currentStep = Number(index);


        updateUI();

    }



    /*
    |--------------------------------------------------------------------------
    | Check Answer
    |--------------------------------------------------------------------------
    */

    function isQuestionAnswered(index) {

        const stepEl =
            document.getElementById(`question-step-${index}`);


        if (!stepEl) {

            return false;

        }


        const checked =
            stepEl.querySelector(
                'input[type="radio"]:checked'
            );


        return checked !== null;

    }



    /*
    |--------------------------------------------------------------------------
    | Update UI
    |--------------------------------------------------------------------------
    */

    function updateUI() {

        let answeredCount = 0;


        /*
        |--------------------------------------------------------------------------
        | Update Question Navigation
        |--------------------------------------------------------------------------
        */

        for (let i = 0; i < totalQuestions; i++) {

            const btn =
                document.getElementById(`nav-btn-${i}`);


            const isAnswered =
                isQuestionAnswered(i);


            if (isAnswered) {

                answeredCount++;

            }


            if (!btn) {

                continue;

            }


            /*
            |--------------------------------------------------------------------------
            | Active Question
            |--------------------------------------------------------------------------
            */

            if (i === currentStep) {

                btn.className =
                    "w-9 h-9 rounded-xl font-bold text-xs border transition-all duration-200 flex items-center justify-center bg-amber-500 border-amber-500 text-white shadow-md ring-2 ring-amber-300 ring-offset-1";

            }


            /*
            |--------------------------------------------------------------------------
            | Answered Question
            |--------------------------------------------------------------------------
            */

            else if (isAnswered) {

                btn.className =
                    "w-9 h-9 rounded-xl font-bold text-xs border transition-all duration-200 flex items-center justify-center bg-emerald-50 border-emerald-300 text-emerald-700 font-extrabold";

            }


            /*
            |--------------------------------------------------------------------------
            | Unanswered Question
            |--------------------------------------------------------------------------
            */

            else {

                btn.className =
                    "w-9 h-9 rounded-xl font-bold text-xs border transition-all duration-200 flex items-center justify-center bg-slate-100 border-slate-200 text-slate-600 hover:bg-slate-200";

            }

        }



        /*
        |--------------------------------------------------------------------------
        | Answer Counter
        |--------------------------------------------------------------------------
        */

        const counterText =
            document.getElementById('answered-count-text');


        if (counterText) {

            counterText.innerText =
                `Terjawab: ${answeredCount} / ${totalQuestions}`;

        }



        /*
        |--------------------------------------------------------------------------
        | Navigation Buttons
        |--------------------------------------------------------------------------
        */

        const prevBtn =
            document.getElementById('prev-btn');


        const nextBtn =
            document.getElementById('next-btn');


        const submitBtn =
            document.getElementById('submit-trigger-btn');



        /*
        |--------------------------------------------------------------------------
        | Previous Button
        |--------------------------------------------------------------------------
        */

        if (prevBtn) {

            prevBtn.disabled =
                currentStep === 0;


            prevBtn.style.opacity =
                currentStep === 0
                    ? "0.4"
                    : "1";


            prevBtn.style.cursor =
                currentStep === 0
                    ? "not-allowed"
                    : "pointer";

        }



        /*
        |--------------------------------------------------------------------------
        | Next / Submit Button
        |--------------------------------------------------------------------------
        */

        if (nextBtn && submitBtn) {

            if (currentStep === totalQuestions - 1) {

                nextBtn.classList.add('hidden');

                submitBtn.classList.remove('hidden');

            }

            else {

                nextBtn.classList.remove('hidden');

                submitBtn.classList.add('hidden');

            }

        }

    }



    /*
    |--------------------------------------------------------------------------
    | Next Question
    |--------------------------------------------------------------------------
    */

    function nextQuestion() {

        if (currentStep < totalQuestions - 1) {

            showQuestion(currentStep + 1);

        }

    }



    /*
    |--------------------------------------------------------------------------
    | Previous Question
    |--------------------------------------------------------------------------
    */

    function prevQuestion() {

        if (currentStep > 0) {

            showQuestion(currentStep - 1);

        }

    }



    /*
    |--------------------------------------------------------------------------
    | Go To Question
    |--------------------------------------------------------------------------
    */

    function goToQuestion(index) {

        showQuestion(Number(index));

    }



    /*
    |--------------------------------------------------------------------------
    | Open Confirmation Modal
    |--------------------------------------------------------------------------
    */

    function openConfirmModal() {

        let answeredCount = 0;


        for (let i = 0; i < totalQuestions; i++) {

            if (isQuestionAnswered(i)) {

                answeredCount++;

            }

        }


        const modalSummary =
            document.getElementById('modal-summary-text');


        if (answeredCount < totalQuestions) {

            modalSummary.innerHTML =
                `Anda baru menjawab <strong class="text-amber-600 font-bold">${answeredCount} dari ${totalQuestions}</strong> soal.<br>
                Masih ada ${totalQuestions - answeredCount} soal yang belum diisi.
                Apakah Anda yakin ingin mengumpulkan sekarang?`;

        }

        else {

            modalSummary.innerHTML =
                `Luar biasa! Anda telah menjawab <strong class="text-emerald-600 font-bold">seluruh ${totalQuestions} soal</strong>.
                <br>Apakah Anda yakin ingin menyelesaikan kuis ini?`;

        }


        document
            .getElementById('confirmModal')
            .classList.remove('hidden');

    }



    /*
    |--------------------------------------------------------------------------
    | Close Confirmation Modal
    |--------------------------------------------------------------------------
    */

    function closeConfirmModal() {

        document
            .getElementById('confirmModal')
            .classList.add('hidden');

    }



    /*
    |--------------------------------------------------------------------------
    | Submit Quiz
    |--------------------------------------------------------------------------
    */

    function submitQuiz() {

        document
            .getElementById('quizForm')
            .submit();

    }



    /*
    |--------------------------------------------------------------------------
    | Initialize Quiz
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', () => {


        /*
        |--------------------------------------------------------------------------
        | Radio Button Listener
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('input[type="radio"]')
            .forEach(radio => {

                radio.addEventListener(
                    'change',
                    updateUI
                );

            });



        /*
        |--------------------------------------------------------------------------
        | Question Navigation Listener
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('[data-question-index]')
            .forEach(button => {

                button.addEventListener('click', () => {

                    const index =
                        Number(button.dataset.questionIndex);


                    goToQuestion(index);

                });

            });



        /*
        |--------------------------------------------------------------------------
        | Show First Question
        |--------------------------------------------------------------------------
        */

        if (totalQuestions > 0) {

            showQuestion(0);

        }

    });

</script>

@endsection
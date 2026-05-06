@extends('layouts.app')

@section('content')
<style>
    @media (max-width: 575.98px) {
        .accordion-button {
            font-size: 19px;
            line-height: 1.25;
            padding: 16px 0;
        }
        .accordion-body {
            font-size: 13px;
            line-height: 1.65;
            padding-bottom: 18px;
        }
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="eyebrow">FAQ</div>
        <h1>Pertanyaan Umum</h1>
        <p>Temukan jawaban untuk pertanyaan yang paling sering diajukan sebelum melakukan sesi foto.</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="accordion" id="faqAccordion">
                    @foreach($faqs as $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
    /* Typography Uniformity */
    .bravo-reviews h3 {
        font-size: 1.5rem !important; /* text-2xl */
        font-weight: 900 !important; /* font-black */
        color: #111827 !important; /* text-gray-900 */
        margin-bottom: 1.5rem !important; /* mb-6 */
        padding-bottom: 1rem !important; /* pb-4 */
        border-bottom: 1px solid #f3f4f6 !important; /* border-gray-100 */
        letter-spacing: -0.025em !important; /* tracking-tight */
    }

    /* Tabular Alignment for Review Summary */
    .bravo-reviews .review-sumary .item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    .bravo-reviews .review-sumary .label {
        width: 100px; /* Fixed width for labels */
        text-align: right;
        padding-right: 15px;
        font-weight: 600;
        color: #4b5563; /* text-gray-600 */
        font-size: 0.875rem;
    }
    .bravo-reviews .review-sumary .progress {
        flex: 1; /* Progress bar takes remaining space */
        height: 8px;
        background-color: #f3f4f6;
        border-radius: 9999px;
        overflow: hidden;
        margin: 0;
    }
    .bravo-reviews .review-sumary .progress .percent {
        height: 100%;
        border-radius: 9999px;
        background: #10b981; /* default green */
    }
    /* Colored Progress Bars */
    .bravo-reviews .review-sumary .item:nth-child(1) .percent { background: linear-gradient(90deg, #10b981, #059669); } /* Excellent */
    .bravo-reviews .review-sumary .item:nth-child(2) .percent { background: linear-gradient(90deg, #84cc16, #65a30d); } /* Very Good */
    .bravo-reviews .review-sumary .item:nth-child(3) .percent { background: linear-gradient(90deg, #eab308, #ca8a04); } /* Average */
    .bravo-reviews .review-sumary .item:nth-child(4) .percent { background: linear-gradient(90deg, #f97316, #ea580c); } /* Poor */
    .bravo-reviews .review-sumary .item:nth-child(5) .percent { background: linear-gradient(90deg, #ef4444, #dc2626); } /* Terrible */

    .bravo-reviews .review-sumary .number {
        width: 50px; /* Fixed width for numbers */
        text-align: right;
        font-weight: 700;
        color: #111827; /* text-gray-900 */
        font-size: 0.875rem;
    }

    /* Vertical Divider & Score Box */
    .bravo-reviews .review-box {
        margin-bottom: 2rem;
    }
    .bravo-reviews .review-box-score {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 2rem;
        background: #f9fafb;
        border-radius: 1rem;
        border: 1px solid #f3f4f6;
    }
    .bravo-reviews .review-score {
        font-size: 4rem;
        font-weight: 900;
        color: #111827;
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    .bravo-reviews .review-score .per-total {
        font-size: 1.5rem;
        color: #9ca3af;
        font-weight: 700;
    }
    .bravo-reviews .review-score-text {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ee6b1a; /* Brand color */
        margin-bottom: 0.25rem;
    }
    .bravo-reviews .review-score-base {
        font-size: 0.875rem;
        color: #6b7280;
    }

    @media(min-width: 992px) {
        .bravo-reviews .review-sumary {
            padding-left: 2rem;
        }
    }
</style>
<div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border-0 p-6 md:p-8 mb-8">
    @include('Review::frontend.form')
</div>

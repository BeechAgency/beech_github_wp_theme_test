/**
 * File blocks.js.
 *
 * Handles any JS required for the blocky boiz
 */
 ( function() {
    document.addEventListener('DOMContentLoaded', function () {
        /* ==== FAQs ==== */
        const faqBtns = document.querySelectorAll('.faq-item .button.faq');

        faqBtns.forEach( (btn) => {
            btn.addEventListener('click', (event) => {
                const btn = event.target;

                const faqItem = btn.parentElement.nextElementSibling;
                const isOpen = faqItem.classList.contains('open');

                btn.classList.toggle('open');
                faqItem.classList.toggle('open');

                return;
            });
        });
        /* ===== END: FAQs ===== */
        /* ==== FACTS ==== */
        const factBtns = document.querySelectorAll('.fact-statement');

        factBtns.forEach( (btn) => {
            btn.addEventListener('click', (event) => {
                const btn = event.currentTarget;
                const id = btn.id;

                const factContent = document.querySelector(`.facts-content-item[data-content="${id}"]`);

                document.querySelector('.fact-statement.active').classList.toggle('active');
                document.querySelector('.facts-content-item.active').classList.toggle('active');

                btn.classList.toggle('active');
                factContent.classList.toggle('active');

                return;
            });
        });
        /* ===== END: FACTS ===== */
    });
}() );

function toggleVisualCalm() {
    const body = document.querySelector('body');

    console.log(body, body.classList);

    body.classList.toggle('visual-calm');
}
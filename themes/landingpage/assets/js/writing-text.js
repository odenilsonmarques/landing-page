const typingElement = document.querySelector("#hero-typing-text");

const phrases = [
    "Sem burocracia",
    "Pagamento facilitado"
];

let phraseIndex = 0;
let charIndex = phrases[0].length;
let deleting = true;

function typeEffect() {
    const currentPhrase = phrases[phraseIndex];

    if (deleting) {
        charIndex--;
        typingElement.textContent = currentPhrase.substring(0, charIndex);

        if (charIndex === 0) {
            deleting = false;
            phraseIndex = (phraseIndex + 1) % phrases.length;
        }

        setTimeout(typeEffect, 60);
        return;
    }

    const nextPhrase = phrases[phraseIndex];

    charIndex++;
    typingElement.textContent = nextPhrase.substring(0, charIndex);

    if (charIndex === nextPhrase.length) {
        deleting = true;
        setTimeout(typeEffect, 1800);
        return;
    }

    setTimeout(typeEffect, 90);
}

setTimeout(typeEffect, 1800);
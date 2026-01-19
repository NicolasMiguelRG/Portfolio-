const halo = document.querySelector(".cursor-halo");

document.addEventListener("mousemove", (e) => {
  halo.style.opacity = 1;
  halo.style.top = `${e.clientY}px`;
  halo.style.left = `${e.clientX}px`;
});

document.addEventListener("mouseleave", () => {
  halo.style.opacity = 0;
});

/* animation p */

document.addEventListener("DOMContentLoaded", () => {
  const p = document.getElementById("typewriter");
  const text = p.textContent.trim();
  p.textContent = "";
  p.style.opacity = 1;

  let index = 0;
  const duration = 2200; // même durée que ton fadeUp
  const speed = duration / text.length;

  function type() {
    if (index < text.length) {
      p.textContent += text[index];
      index++;
      setTimeout(type, speed);
    }
  }

  type();
});

// MESSAGE DE CONFIRMATION ANIMÉ
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".contact-form");
  const success = document.querySelector(".form-success");

  if (form) {
    form.addEventListener("submit", () => {
      // On NE bloque plus l'envoi du formulaire
      // e.preventDefault();  ← supprimé

      // On affiche l'animation de succès
      success.classList.add("visible");

      setTimeout(() => {
        success.classList.remove("visible");
        form.reset();
      }, 3000);
    });
  }
});

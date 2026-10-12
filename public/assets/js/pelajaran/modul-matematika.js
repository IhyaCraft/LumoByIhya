document.addEventListener("DOMContentLoaded", () => {
    const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    const progressBar = document.querySelector(".progress-fill");
    const progressValue = document.querySelector("[data-progress]");
    const lessonCards = document.querySelectorAll(".lesson-card");
    const revealElements = document.querySelectorAll("[data-reveal]");
    const floatingElements = document.querySelectorAll("[data-float]");
    const mascot = document.querySelector(".v-maskot");
    const MAX_PROGRESS = 100;

    const getProgress = () => {
        const value = Number(progressValue?.dataset.progress ?? 0);
        return Number.isFinite(value)
            ? Math.min(MAX_PROGRESS, Math.max(0, value))
            : 0;
    };

    const animateProgress = () => {
        if (!progressBar) return;

        const progress = getProgress();

        progressBar.style.width = reduceMotion ? `${progress}%` : "0%";
        progressBar.setAttribute("role", "progressbar");
        progressBar.setAttribute("aria-valuemin", "0");
        progressBar.setAttribute("aria-valuemax", String(MAX_PROGRESS));
        progressBar.setAttribute("aria-valuenow", String(progress));

        if (!reduceMotion) {
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    progressBar.style.width = `${progress}%`;
                });
            });
        }
    };

    const revealOnScroll = () => {
        if (reduceMotion || !("IntersectionObserver" in window)) {
            revealElements.forEach((element) => {
                element.classList.add("is-visible");
            });
            return;
        }

        const observer = new IntersectionObserver(
            (entries, currentObserver) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-visible");
                        currentObserver.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.12,
                rootMargin: "0px 0px -35px 0px"
            }
        );

        revealElements.forEach((element) => observer.observe(element));
    };

    const animateCards = () => {
        lessonCards.forEach((card, index) => {
            card.style.setProperty("--card-index", index);

            if (!reduceMotion) {
                card.animate(
                    [
                        {
                            opacity: 0,
                            transform: "translateY(22px) scale(0.98)"
                        },
                        {
                            opacity: 1,
                            transform: "translateY(0) scale(1)"
                        }
                    ],
                    {
                        duration: 450,
                        delay: Math.min(index * 90, 450),
                        easing: "cubic-bezier(0.22, 1, 0.36, 1)",
                        fill: "both"
                    }
                );
            }
        });
    };

    const addCardInteractions = () => {
        lessonCards.forEach((card) => {
            card.addEventListener("pointermove", (event) => {
                if (reduceMotion || event.pointerType !== "mouse") return;

                const rect = card.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                const y = (event.clientY - rect.top) / rect.height;

                card.style.setProperty("--pointer-x", `${x * 100}%`);
                card.style.setProperty("--pointer-y", `${y * 100}%`);
            });

            card.addEventListener("pointerenter", () => {
                if (reduceMotion) return;
                card.classList.add("is-hovered");
            });

            card.addEventListener("pointerleave", () => {
                card.classList.remove("is-hovered");
                card.style.removeProperty("--pointer-x");
                card.style.removeProperty("--pointer-y");
            });

            card.addEventListener("focusin", () => {
                card.classList.add("is-hovered");
            });

            card.addEventListener("focusout", (event) => {
                if (!card.contains(event.relatedTarget)) {
                    card.classList.remove("is-hovered");
                }
            });
        });
    };

    const addFloatingMotion = () => {
        if (reduceMotion) return;

        floatingElements.forEach((element, index) => {
            element.animate(
                [
                    { transform: "translateY(0) rotate(0deg)" },
                    { transform: `translateY(-9px) rotate(${index % 2 ? 4 : -4}deg)` },
                    { transform: "translateY(0) rotate(0deg)" }
                ],
                {
                    duration: 2600 + index * 350,
                    delay: index * 180,
                    iterations: Infinity,
                    easing: "ease-in-out"
                }
            );
        });
    };

    const addMascotInteraction = () => {
        if (!mascot) return;

        mascot.addEventListener("click", () => {
            if (reduceMotion) return;

            mascot.animate(
                [
                    { transform: "scale(1) rotate(0deg)" },
                    { transform: "scale(1.12) rotate(-8deg)" },
                    { transform: "scale(1.08) rotate(8deg)" },
                    { transform: "scale(1) rotate(0deg)" }
                ],
                {
                    duration: 480,
                    easing: "cubic-bezier(0.22, 1, 0.36, 1)"
                }
            );
        });
    };

    const addButtonFeedback = () => {
        document.querySelectorAll(".btn, .btn-primary, .btn-secondary").forEach((button) => {
            button.addEventListener("pointerdown", () => {
                if (reduceMotion) return;
                if (button.matches(":disabled") || button.getAttribute("aria-disabled") === "true") return;

                button.animate(
                    [
                        { transform: "scale(1)" },
                        { transform: "scale(0.97)" },
                        { transform: "scale(1)" }
                    ],
                    {
                        duration: 220,
                        easing: "ease-out"
                    }
                );
            });
        });
    };

    animateProgress();
    revealOnScroll();
    animateCards();
    addCardInteractions();
    addFloatingMotion();
    addMascotInteraction();
    addButtonFeedback();
});
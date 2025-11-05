// (function() {

//     // ===== CSRF SETUP =====
//     const csrfTokenName = "_csrf";
//     const csrfTokenValue = (function() {
//         // Generate random CSRF token
//         const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
//         let token = '';
//         for (let i = 0; i < 32; i++) token += chars.charAt(Math.floor(Math.random() * chars.length));
//         return token;
//     })();

//     // On page load, inject CSRF if not present
//     document.addEventListener("DOMContentLoaded", function() {
//         $('form[data-ajax="1"]').each(function() {
//             if (!$(this).find(`input[name="${csrfTokenName}"]`).length) {
//                 $(this).append(`<input type="hidden" name="${csrfTokenName}" value="${csrfTokenValue}">`);
//             }
//         });
//     });

//     // ===== TOAST FUNCTION =====
//     function showMessage(message, isError = false, timer = 3000) {
//         const toast = document.createElement("div");
//         toast.textContent = message;
//         Object.assign(toast.style, {
//             position: "fixed",
//             top: "30px",
//             left: "50%",
//             transform: "translateX(-50%)",
//             backgroundColor: isError ? "#dc3545" : "#28a745",
//             color: "#fff",
//             padding: "14px 22px",
//             borderRadius: "10px",
//             fontSize: "15px",
//             boxShadow: "0 2px 8px rgba(0,0,0,0.3)",
//             zIndex: "99999999999999999999999999999999999999999999999999999999999999999999999",
//             opacity: "1",
//             transition: "opacity 0.5s"
//         });
//         document.body.appendChild(toast);

//         setTimeout(() => {
//             toast.style.opacity = "0";
//             setTimeout(() => toast.remove(), 500);
//         }, timer);
//     }

//     // ===== UNIVERSAL AJAX HANDLER =====
//     function submitForm(form) {
//         const $form = $(form);
//         let url = $form.attr("action");
//         let method = ($form.attr("method") || "POST").toUpperCase();

//         if (!url || !method) {
//             showMessage("Missing URL or METHOD in form.", true);
//             return;
//         }

//         // Prepare FormData for file uploads
//         const formData = new FormData(form);

//         // Ensure CSRF is present
//         if (!formData.has(csrfTokenName)) {
//             formData.append(csrfTokenName, csrfTokenValue);
//         }

//         $.ajax({
//             url: url,
//             method: method,
//             data: formData,
//             processData: false,
//             contentType: false,
//             success: function(response) {
//                 if (typeof response === "object" && response.message) {
//                     showMessage(response.message, !response.success);
//                 } else {
//                     showMessage(response);
//                 }
//                 setTimeout(function () {
//                 $('.modal').modal('hide');
//                 },3000);
//                 $('form')[0].reset();
//             },
//             error: function(xhr) {
//                 // alert(JSON.stringify(xhr));
//                 const msg = xhr.responseJSON?.message || "An error occurred while submitting.";
//                 showMessage(msg, true);
//             }
//         });
//     }

//     // ===== AUTO-HOOK FOR ALL FORMS =====
//     $(document).on("submit", 'form[data-ajax="1"]', function(e) {
//         e.preventDefault();
//         submitForm(this);
//     });

// })();
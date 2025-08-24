const translations = {
  "ar": {
    "home": "🏠 الرئيسية",
    "services": "💼 خدماتنا",
    "login": "🔑 تسجيل الدخول",
    "register": "📝 إنشاء حساب",
    "welcome": "مرحباً بك في بنك NCSC",
    "desc": "الأمن، السرعة، والموثوقية في جميع معاملاتك المالية",
    "discover": "اكتشف خدماتنا",
    "form_username": "اسم المستخدم",
    "form_password": "كلمة المرور",
    "form_login": "دخول",
    "form_register": "إنشاء الحساب"
  },
  "en": {
    "home": "🏠 Home",
    "services": "💼 Our Services",
    "login": "🔑 Login",
    "register": "📝 Register",
    "welcome": "Welcome to NCSC Bank",
    "desc": "Security, speed, and reliability in all your financial transactions",
    "discover": "Discover Our Services",
    "form_username": "Username",
    "form_password": "Password",
    "form_login": "Login",
    "form_register": "Register"
  }
};

function setLanguage(lang) {
  localStorage.setItem("lang", lang);
  applyTranslations(lang);
}

function applyTranslations(lang) {
  document.querySelectorAll("[data-key]").forEach(el => {
    let key = el.getAttribute("data-key");
    if (translations[lang][key]) {
      el.textContent = translations[lang][key];
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  let savedLang = localStorage.getItem("lang") || "ar";
  applyTranslations(savedLang);
});

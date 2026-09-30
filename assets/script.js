// PROJECT DATA
const projects = [
  {
    title: "Student Management System",
    type: "PHP & MySQL",
    category: "backend",
    icon: "bi-mortarboard",
    description:
      "A school management project bringing student records and academic workflows into one system.",
    features: [
      "Admin, teacher, and student dashboards",
      "Student profiles, attendance, courses, and results",
      "Database-backed records and CRUD workflows"
    ],
    stack: ["PHP", "MySQL", "Bootstrap", "AJAX"]
  },

  {
    title: "Developer Portfolio CMS",
    type: "PHP & MySQL",
    category: "backend",
    icon: "bi-window-stack",
    description:
      "A dynamic portfolio project for managing projects, skills, and incoming contact messages.",
    features: [
      "Administrator login and dashboard",
      "Project image uploads and featured projects",
      "Skills and message management"
    ],
    stack: ["PHP", "MySQL", "Bootstrap"]
  },

  {
    title: "E-commerce Website",
    type: "Web development",
    category: "backend",
    icon: "bi-bag",
    description:
      "An online store project exploring product discovery, shopping carts, and user accounts.",
    features: [
      "Product categories and search",
      "Shopping cart interactions",
      "Account and administrator workflows"
    ],
    stack: ["HTML", "CSS", "JavaScript", "PHP"]
  },

  {
    title: "Library Management System",
    type: "PHP & MySQL",
    category: "backend",
    icon: "bi-book",
    description:
      "A library project focused on organising books, member accounts, and borrowing records.",
    features: [
      "Member registration and authentication",
      "Administrator and member roles",
      "Book borrowing records"
    ],
    stack: ["PHP", "MySQL", "Bootstrap"]
  },

  {
    title: "Hotel Booking System",
    type: "PHP & MySQL",
    category: "backend",
    icon: "bi-building",
    description:
      "A booking project exploring room categories, pricing, and date availability.",
    features: [
      "Room categories and rates",
      "Booking dates and availability",
      "Checks for conflicting reservations"
    ],
    stack: ["PHP", "MySQL", "Bootstrap"]
  },

  {
    title: "React Interface Collection",
    type: "Frontend",
    category: "frontend",
    icon: "bi-columns-gap",
    description:
      "Interface exercises exploring reusable React components, layouts, state, and events.",
    features: [
      "Checkout and wallet interfaces",
      "Dashboard and job board layouts",
      "Component styling and state-driven interactions"
    ],
    stack: ["React", "CSS", "JavaScript"]
  }
];

const grid = document.getElementById("project-grid");

// RENDER PROJECT CARDS
function render(filter = "all") {
  grid.innerHTML = projects
    .map((project, index) => ({
      project,
      index
    }))
    .filter(({ project }) => {
      return filter === "all" || project.category === filter;
    })
    .map(({ project, index }) => {
      return `
        <div class="col-md-6 col-lg-4">
          <article class="project-card">

            <div class="project-top">
              <i
                class="bi ${project.icon}"
                aria-hidden="true"
              ></i>

              <span class="project-number">
                PROJECT ${String(index + 1).padStart(2, "0")}
              </span>
            </div>

            <div class="project-body">
              <div class="project-type">
                ${project.type.toUpperCase()}
              </div>

              <h3>${project.title}</h3>

              <p>${project.description}</p>

              <div class="d-flex flex-wrap gap-2">
                ${project.stack
                  .map((technology) => {
                    return `
                      <span class="tag">${technology}</span>
                    `;
                  })
                  .join("")}
              </div>

              <button
                class="project-button"
                data-project="${index}"
                data-bs-toggle="modal"
                data-bs-target="#projectModal"
                aria-label="Read about ${project.title}"
              >
                Project details
              </button>
            </div>

          </article>
        </div>
      `;
    })
    .join("");
}

// INITIAL PROJECT DISPLAY
render();

// PROJECT FILTER BUTTONS
document.querySelectorAll(".filter").forEach((button) => {
  button.addEventListener("click", () => {
    document.querySelectorAll(".filter").forEach((filterButton) => {
      const isActive = filterButton === button;

      filterButton.classList.toggle("active", isActive);

      filterButton.setAttribute(
        "aria-pressed",
        String(isActive)
      );
    });

    render(button.dataset.filter);
  });
});

// POPULATE PROJECT MODAL
grid.addEventListener("click", (event) => {
  const button = event.target.closest("[data-project]");

  if (!button) {
    return;
  }

  const project = projects[Number(button.dataset.project)];

  document.getElementById("modalTitle").textContent =
    project.title;

  document.getElementById("modalDescription").textContent =
    project.description;

  document.getElementById("modalFeatures").innerHTML =
    project.features
      .map((feature) => `<li>${feature}</li>`)
      .join("");

  document.getElementById("modalStack").innerHTML =
    project.stack
      .map((technology) => {
        return `<span class="tag">${technology}</span>`;
      })
      .join("");
});

// CURRENT COPYRIGHT YEAR
document.getElementById("year").textContent =
  new Date().getFullYear();

// CLOSE MOBILE NAVIGATION AFTER CLICKING A LINK
document.querySelectorAll("#navigation a").forEach((link) => {
  link.addEventListener("click", () => {
    const navigation = document.getElementById("navigation");

    if (
      navigation.classList.contains("show") &&
      window.bootstrap
    ) {
      bootstrap.Collapse
        .getOrCreateInstance(navigation)
        .hide();
    }
  });
});

// Highlight the section currently in view.
const sectionLinks = [
  ...document.querySelectorAll('#navigation a[href^="#"]')
];

const pageSections = [
  ...document.querySelectorAll("main > section[id]")
];

const navbar = document.querySelector(".navbar");
let sectionUpdatePending = false;

function updateActiveSection() {
  const marker = navbar.getBoundingClientRect().height + 24;
  let currentId = pageSections[0].id;

  pageSections.forEach((section) => {
    if (section.getBoundingClientRect().top <= marker) {
      currentId = section.id;
    }
  });

  // Highlight Contact when reaching the bottom of the page.
  if (
    window.scrollY + window.innerHeight >=
    document.documentElement.scrollHeight - 2
  ) {
    currentId = pageSections[pageSections.length - 1].id;
  }

  sectionLinks.forEach((link) => {
    const active = link.getAttribute("href") === `#${currentId}`;

    link.classList.toggle("active", active);

    if (active) {
      link.setAttribute("aria-current", "location");
    } else {
      link.removeAttribute("aria-current");
    }
  });

  sectionUpdatePending = false;
}

function scheduleSectionUpdate() {
  if (!sectionUpdatePending) {
    sectionUpdatePending = true;
    requestAnimationFrame(updateActiveSection);
  }
}

window.addEventListener("scroll", scheduleSectionUpdate, {
  passive: true
});

window.addEventListener("resize", scheduleSectionUpdate);
window.addEventListener("load", updateActiveSection);

document
  .getElementById("navigation")
  .addEventListener("hidden.bs.collapse", updateActiveSection);

updateActiveSection();
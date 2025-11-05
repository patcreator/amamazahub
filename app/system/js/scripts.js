const API = "/PDT-NEW/projects/pdo/app/system/api/contacts/";
const list = document.getElementById("contactList");
const form = document.getElementById("contactForm");
const search = document.getElementById("search");

let contacts = [];
let editingId = null;

async function fetchContacts() {
  const res = await fetch(API + "read.php");
  contacts = await res.json();
  renderContacts();
}

function renderContacts() {
  const filter = search.value.toLowerCase();
  const filtered = contacts.filter(c => c.name.toLowerCase().includes(filter));
  list.innerHTML = filtered.map(c => `
    <li class="py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-800 px-2 rounded-lg transition">
      <div>
        <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">${c.name}</p>
        <p class="text-gray-500 dark:text-gray-300 text-sm">${c.phone}</p>
        <p class="text-gray-400 dark:text-gray-300 text-sm">${c.email || ''}</p>
      </div>
      <div class="flex space-x-2">
        <button onclick="editContact(${c.id})" class="text-blue-500 hover:text-blue-700">Edit</button>
        <button onclick="deleteContact(${c.id})" class="text-red-500 hover:text-red-700">Delete</button>
      </div>
    </li>
  `).join('');
}

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const name = document.getElementById("name").value.trim();
  const phone = document.getElementById("phone").value.trim();
  const email = document.getElementById("email").value.trim();

  if (!name || !phone) return alert("Name and phone are required.");

  const contact = { name, phone, email };
  const url = editingId ? API + "update.php" : API + "create.php";
  const body = editingId ? { ...contact, id: editingId } : contact;

  await fetch(url, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(body),
  });

  editingId = null;
  form.reset();
  fetchContacts();
});

async function deleteContact(id) {
  if (!confirm("Delete this contact?")) return;
  await fetch(API + "delete.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id }),
  });
  fetchContacts();
}

function editContact(id) {
  const c = contacts.find(x => x.id === id);
  document.getElementById("name").value = c.name;
  document.getElementById("phone").value = c.phone;
  document.getElementById("email").value = c.email || '';
  editingId = id;
}

search.addEventListener("input", renderContacts);
fetchContacts();

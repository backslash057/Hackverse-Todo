const API_BASE = '/api/todo';

const els = {
  input: document.querySelector('.input'),
  addBtn: document.querySelector('.add-button'),
  container: document.querySelector('.container'),
  toastContainer: document.getElementById('toast-container'),
};

function showToast(message, type = 'success') {
  const t = document.createElement('div');
  t.className = `toast ${type}`;
  t.textContent = (type === 'error' ? '⚠️ ' : '✅ ') + message;
  els.toastContainer.appendChild(t);
  setTimeout(() => t.remove(), 3000);
}

class Item {
  constructor({ id, title }) {
    this.id = id;
    this.title = title;
    this.render();
  }

  render() {
    this.el = document.createElement('div');
    this.el.className = 'item';
    this.el.dataset.id = this.id;

    this.input = document.createElement('input');
    this.input.type = 'text';
    this.input.value = this.title;
    this.input.disabled = true;
    this.input.className = 'item_input';

    this.editBtn = document.createElement('button');
    this.editBtn.className = 'edit-button';
    this.editBtn.textContent = 'EDIT';

    this.delBtn = document.createElement('button');
    this.delBtn.className = 'remove-button';
    this.delBtn.textContent = 'REMOVE';

    this.el.append(this.input, this.editBtn, this.delBtn);
    els.container.appendChild(this.el);

    this.editBtn.addEventListener('click', () => this.toggleEdit());
    this.delBtn.addEventListener('click', () => this.delete());
    this.input.addEventListener('blur', () => this.update());
  }

  toggleEdit() {
    this.input.disabled = !this.input.disabled;
    if (!this.input.disabled) this.input.focus();
  }

  async update() {
    const newTitle = this.input.value.trim();
    if (!newTitle || newTitle === this.title) return;
    try {
      const res = await fetch(API_BASE, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: this.id, title: newTitle }),
      });
      const data = await res.json();
      if (res.ok) {
        this.title = newTitle;
        showToast('Task updated');
      } else {
        showToast(data.error || 'Update failed', 'error');
      }
    } catch {
      showToast('Network error', 'error');
    }
  }

  async delete() {
    try {
      const res = await fetch(API_BASE, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: this.id }),
      });
      const data = await res.json();
      if (res.ok) {
        this.el.remove();
        showToast('Task deleted');
      } else {
        showToast(data.error || 'Delete failed', 'error');
      }
    } catch {
      showToast('Network error', 'error');
    }
  }
}

async function fetchTasks() {
  try {
    const res = await fetch(API_BASE);
    const tasks = await res.json();
    if (Array.isArray(tasks)) tasks.forEach(t => new Item(t));
    else showToast(tasks.error || 'Failed to load', 'error');
  } catch {
    showToast('Network error', 'error');
  }
}

async function addTask() {
  const title = els.input.value.trim();
  if (!title) return;
  try {
    const res = await fetch(API_BASE, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ title }),
    });
    const data = await res.json();
    if (res.ok) {
      new Item(data.task || { id: data.id, title });
      els.input.value = '';
      showToast('Task added');
    } else {
      showToast(data.error || 'Add failed', 'error');
    }
  } catch {
    showToast('Network error', 'error');
  }
}

els.addBtn.addEventListener('click', addTask);
window.addEventListener('keydown', e => { if (e.key === 'Enter') addTask(); });

fetchTasks();

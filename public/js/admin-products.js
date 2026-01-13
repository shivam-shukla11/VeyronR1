document.addEventListener("DOMContentLoaded", () => {
  const tableBody = document.getElementById("productTableBody");
  const form = document.getElementById("productForm");
  const submitBtn = document.getElementById("submitBtn");
  const searchBox = document.getElementById("searchBox");
  const categoryFilter = document.getElementById("categoryFilter");
  let products = [];
  let editId = null;

  // Fetch products
  async function fetchProducts() {
    const res = await fetch("admin-products.php?json=1");
    products = await res.json();
    renderProducts(products);
  }

  // Render products table
  function renderProducts(list) {
    tableBody.innerHTML = "";
    list.forEach(p => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><img src="${p.image}" style="width:60px;border-radius:8px;"></td>
        <td>${p.sku}</td>
        <td>${p.name}</td>
        <td>${p.category}</td>
        <td>${p.price}</td>
        <td>${p.stock}</td>
        <td>
          <button class="btn secondary" data-edit='${JSON.stringify(p)}'>Edit</button>
          <button class="btn secondary" data-delete='${p.id}'>Delete</button>
        </td>
      `;
      tableBody.appendChild(tr);
    });
  }

  // Filter products
  function filterProducts() {
    const text = searchBox.value.toLowerCase();
    const category = categoryFilter.value;
    const filtered = products.filter(p =>
      (p.name.toLowerCase().includes(text) || p.sku.toLowerCase().includes(text)) &&
      (category === "" || p.category === category)
    );
    renderProducts(filtered);
  }

  searchBox.addEventListener("input", filterProducts);
  categoryFilter.addEventListener("change", filterProducts);

  // Edit / Delete
  tableBody.addEventListener("click", async e => {
    if(e.target.dataset.edit){
      const p = JSON.parse(e.target.dataset.edit);
      editId = p.id;
      document.getElementById("name").value = p.name;
      document.getElementById("sku").value = p.sku;
      document.getElementById("category").value = p.category;
      document.getElementById("price").value = p.price;
      document.getElementById("stock").value = p.stock;
      document.getElementById("description").value = p.description;
      submitBtn.textContent = "Update Product";
    }

    if(e.target.dataset.delete){
      if(confirm("Delete this product?")){
        await fetch(`admin-products.php?delete=${e.target.dataset.delete}`);
        fetchProducts();
      }
    }
  });

  // Submit form
  form.addEventListener("submit", async e => {
    e.preventDefault();
    form.submit(); // submit normally for file upload
  });

  fetchProducts();
});

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Adicionando Produto
      </h2>
      <Link
        href="/products"
        class="ml-2 text-blue-500 dark:text-blue-300 hover:underline"
      >
        Voltar
      </Link>
    </template>
    <div
      class="p-4 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded"
    >
      <form @submit.prevent="form.post('/products')" class="space-y-4">
        <div>
          <label class="block mb-1">Nome:</label>
          <input
            v-model="form.name"
            class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-2 w-full rounded"
          />
          <span
            class="text-red-600 dark:text-red-400 text-sm"
            v-if="form.errors?.name"
          >
            {{ form.errors.name }}
          </span>
        </div>

        <div>
          <label class="block mb-1">
            Descrição (suporta &lt;p&gt;, &lt;br&gt;, &lt;b&gt;,
            &lt;strong&gt;):
          </label>
          <textarea
            v-model="form.description"
            class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-2 w-full rounded"
          ></textarea>
          <span
            class="text-red-600 dark:text-red-400 text-sm"
            v-if="form.errors?.description"
          >
            {{ form.errors.description }}
          </span>
        </div>

        <div>
          <label class="block mb-1">Preço de Venda:</label>
          <input
            type="number"
            step="any"
            v-model="form.sale_price"
            class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-2 w-full rounded"
          />
          <span
            class="text-red-600 dark:text-red-400 text-sm"
            v-if="form.errors?.sale_price"
          >
            {{ form.errors.sale_price }}
          </span>
        </div>

        <div>
          <label class="block mb-1">Custo:</label>
          <input
            type="number"
            step="any"
            v-model="form.cost_price"
            class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-2 w-full rounded"
          />
          <span
            class="text-red-600 dark:text-red-400 text-sm"
            v-if="form.errors?.cost_price"
          >
            {{ form.errors.cost_price }}
          </span>
        </div>

        <div>
          <label class="block mb-1">Adicionar Imagens:</label>
          <input
            type="file"
            @change="handleImages"
            multiple
            accept=".jpg,.png"
            class="dark:text-gray-100"
          />
        </div>

        <div class="pt-2">
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
          >
            Salvar
          </button>
          <Link
            href="/products"
            class="ml-2 text-blue-500 dark:text-blue-300 hover:underline"
          >
            Cancelar
          </Link>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link, router, useForm } from "@inertiajs/vue3";
import NavBar from "../Shared/NavBar.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const form = useForm({
  name: "",
  description: "",
  sale_price: "",
  cost_price: "",
  images: [],
});

function handleImages(e) {
  form.images = Array.from(e.target.files);
}

function submit() {
  const data = new FormData();
  data.append("name", form.value.name);
  data.append("description", form.value.description);
  data.append("sale_price", form.value.sale_price);
  data.append("cost_price", form.value.cost_price);
  for (let i = 0; i < form.images.length; i++) {
    data.append(`images[${i}]`, form.images[i]);
  }
  router.post("/products", data);
}
</script>

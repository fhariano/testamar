<template>
  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Editando Produto
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
      <form @submit.prevent="submit" class="space-y-4">
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

        <div>
          <p class="mb-1">Imagens existentes:</p>
          <div class="flex gap-2 flex-wrap">
            <div
              v-for="img in product.images"
              :key="img.id"
              class="bg-gray-100 dark:bg-gray-800 p-2 rounded"
            >
              <img
                :src="`/storage/${img.image_path}`"
                class="w-20 h-20 object-cover rounded border border-gray-300 dark:border-gray-600"
              />
              <button
                @click.prevent="deleteImage(img.id)"
                class="block mt-1 text-red-500 dark:text-red-400 text-sm"
              >
                Remover
              </button>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
          >
            Atualizar
          </button>
          <Link
            href="/products"
            class="ml-2 text-blue-500 dark:text-blue-300 hover:underline"
          >
            Voltar
          </Link>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const { props } = usePage();
const product = props.product;

const form = useForm({
  name: product.name,
  description: product.description,
  sale_price: product.sale_price,
  cost_price: product.cost_price,
  images: [],
});

function handleImages(e) {
  form.images = Array.from(e.target.files);
}

// const submit = () => {
//   form.post(`/product/${product.id}`, form);
// };

const submit = () => {
  form.post(route("product.update", props.product.id), {
    preserveScroll: true,
    onSuccess: () => form.reset("images"),
  });
};

function deleteImage(id) {
  if (confirm("Remover imagem?")) {
    router.delete(`/product-images/${id}`, {
      preserveScroll: true,
      onSuccess: () => {
        window.location.reload();
      },
    });
  }
}
</script>

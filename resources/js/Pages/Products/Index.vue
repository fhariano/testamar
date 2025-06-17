<template>
  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Lista de Produtos
      </h2>
    </template>
    <div class="p-4">
      <h1 class="text-xl mb-4">Lista de Produtos</h1>
      <Link
        href="/product/create"
        class="bg-blue-500 text-white px-4 py-2 rounded"
        >Novo Produto</Link
      >

      <table class="w-full mt-4 border border-gray-300 dark:border-gray-600">
        <thead>
          <tr
            class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100"
          >
            <th class="border border-gray-300 dark:border-gray-600 p-2">
              Nome
            </th>
            <th class="border border-gray-300 dark:border-gray-600 p-2">
              Preço de Custo
            </th>
            <th class="border border-gray-300 dark:border-gray-600 p-2">
              Preço de Venda
            </th>
            <th class="border border-gray-300 dark:border-gray-600 p-2">
              Ações
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="product in products"
            :key="product.id"
            class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100"
          >
            <td class="border border-gray-300 dark:border-gray-600 p-2">
              {{ product.name }}
            </td>
            <td
              class="border border-gray-300 dark:border-gray-600 p-2 text-right"
            >
              R$ {{ product.cost_price }}
            </td>
            <td
              class="border border-gray-300 dark:border-gray-600 p-2 text-right"
            >
              R$ {{ product.sale_price }}
            </td>
            <!-- <td
              class="border border-gray-300 dark:border-gray-600 p-2 text-center"
            >
              <span
                :class="{
                  'text-green-600 dark:text-green-400':
                    product.status === 'ativo',
                  'text-yellow-600 dark:text-yellow-400':
                    product.status === 'fora',
                  'text-gray-600 dark:text-gray-400':
                    product.status === 'inativo',
                }"
                class="font-semibold"
              >
                {{ statusLabel(product.status) }}
              </span>
            </td> -->
            <td
              class="border border-gray-300 dark:border-gray-600 p-2 text-center"
            >
              <Link
                :href="`/products/${product.id}`"
                class="text-blue-500 dark:text-blue-300 ml-2"
              >
                Editar
              </Link>
              <button
                @click="destroy(product.id)"
                class="text-red-500 dark:text-red-400 ml-2"
              >
                Excluir
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <pagination :elements="props.products"></pagination>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { onMounted } from "vue";
const { props } = usePage();
const products = props.products.data;

const statusLabel = (status) => {
  switch (status) {
    case "ativo":
      return "Ativo";
    case "inativo":
      return "Inativo";
    case "fora":
      return "Fora de Estoque";
    default:
      return "Desconhecido";
  }
};

function destroy(id, key) {
  if (confirm("Tem certeza que deseja excluir?")) {
    router.delete(`/products/${id}`, {
      preserveState: true,
      preserveScroll: true,
      onError: (errors) => console.error(errors),
      onSuccess: () => {
        const index = this.products.findIndex((item) => item.id === id);
        if (index !== -1) {
          this.products.splice(index, 1);
        }
      },
    });
  }
}
</script>

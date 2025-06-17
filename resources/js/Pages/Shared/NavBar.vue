<template>
  <nav class="bg-gray-800 p-4 text-white flex gap-4">
    <Link v-if="user.role === 'admin'" href="/users">Usuários</Link>
    <Link href="/products">Produtos</Link>
    <Link href="/logout" method="post" as="button">Sair</Link>
  </nav>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const { props } = usePage();
const user = props.auth.user;
</script>

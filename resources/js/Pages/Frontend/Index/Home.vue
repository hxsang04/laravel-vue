<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue'
</script>

<template>
    <Head title="Home"/>

    <ShopLayout>
        <div class="text-center m-5 p-5">
            <h2 v-if="$page.props.auth.user">You're logged in!</h2>
            <h2 v-else>You are not logged in!!</h2>
        </div>
    </ShopLayout>
</template>
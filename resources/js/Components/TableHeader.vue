
<script setup>

defineProps({
    href: String,
    modelValue: {
        type: String,
    },

});

</script>

<template>
    <div class="card-header">
        <div>
            <div class="input-group">
                <input type="text" placeholder="Search name" class="form-control" 
                    :value="modelValue"
                    @input="$emit('update:modelValue', $event.target.value)"
                />
                <span class="input-group-append">
                    <button @click="$emit('search')" class="btn btn-primary">
                        <font-awesome-icon icon="fa fa-search" />&nbsp;
                        Search
                    </button>
                </span>
            </div>
        </div>

        <a class="ml-5 text-decoration-none border border-primary p-2" :href="href">
            <slot name="link" />
        </a>
        <div class="btn-actions-pane-right">
            <slot />
        </div>
    </div>
</template>
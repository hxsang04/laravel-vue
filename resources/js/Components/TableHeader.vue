
<script setup>

defineProps({
    href: String,
    modelValue: {
        type: String,
        required: true,
    },

});

</script>

<template>
    <div class="card-header">
        <div>
            <div class="input-group">
                <input type="text" placeholder="Search everything" class="form-control" 
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
            <slot />
        </a>

        <div class="btn-actions-pane-right">
            <div role="group" class="btn-group-sm btn-group">
                <input type="file" />
                <button @click="$emit('import')" class="btn btn-focus ml-2">Import</button>
                <button @click="$emit('export')" class="btn btn-focus ml-2">Export</button>
            </div>
        </div>
    </div>
</template>
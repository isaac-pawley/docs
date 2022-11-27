<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({
    page: Object,
});

// Set the active navigation state...
Array.from(document.querySelectorAll('#header a, #sidebar a')).forEach(link => {
    if (link.hostname === location.hostname
        && (link.pathname === location.pathname || (link.pathname === '/introduction' && location.pathname === '/'))
    ) {
        link.classList.add('active')
        if (link.parentNode.tagName === 'LI') {
            link.parentNode.parentNode.parentNode.classList.add('sub--on')
        }
    }
})

// Make the navigation headings expandable...
Array.from(document.querySelectorAll('.docs_sidebar h2')).forEach(el => {
    if (el.children.length > 1) {
        return
    }

    el.addEventListener('click', (e) => {
        const active = el.parentNode.classList.contains('sub--on');

        [...document.querySelectorAll('.docs_sidebar ul li')].forEach(el => el.classList.remove('sub--on'));

        if (! active) {
            el.parentNode.classList.add('sub--on');
        }
    })
})

// Highlight the active section in the table of contents...
function setActiveTableOfContents () {
    const links = Array.from(document.querySelectorAll('.table-of-contents a'))
    const lastVisible = links
        .slice()
        .reverse()
        .find(link => {
            const el = document.querySelector(link.hash)

            return el.getBoundingClientRect().top <= 56;
        }) ?? links[0]

    links.forEach(link => {
        if (link === lastVisible) {
            link.classList.add('active')
        } else {
            link.classList.remove('active')
        }
    })
}

setActiveTableOfContents()
window.addEventListener('scroll', setActiveTableOfContents, { passive: true })
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Page
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>{{ page.name }}</div>
                    <article class="prose max-w-none p-4" v-html="page.markdown"></article>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

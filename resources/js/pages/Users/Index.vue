<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    Users as UsersIcon,
    Search,
    Plus,
    Pencil,
    Trash2,
    ArrowUpDown,
} from 'lucide-vue-next';
import type { BreadcrumbItem, User } from '@/types';

interface PaginatedUsers {
    data: User[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
}

interface Props {
    users: PaginatedUsers;
    filters: {
        search?: string;
        sort?: string;
        direction?: string;
    };
}

const props = defineProps<Props>();
const page = usePage();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Users',
        href: '/dashboard/users',
    },
];

// Search
const search = ref(props.filters.search || '');
const searchTimeout = ref<ReturnType<typeof setTimeout> | null>(null);

watch(search, (value) => {
    if (searchTimeout.value) {
        clearTimeout(searchTimeout.value);
    }
    searchTimeout.value = setTimeout(() => {
        router.get('/dashboard/users', { search: value }, { preserveState: true });
    }, 300);
});

// Dialog States
const showCreateDialog = ref(false);
const showEditDialog = ref(false);
const showDeleteDialog = ref(false);
const selectedUser = ref<User | null>(null);

// Form States
const createForm = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const editForm = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const processing = ref(false);

// Actions
const openCreateDialog = () => {
    createForm.value = {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    };
    showCreateDialog.value = true;
};

const openEditDialog = (user: User) => {
    selectedUser.value = user;
    editForm.value = {
        name: user.name,
        email: user.email,
        password: '',
        password_confirmation: '',
    };
    showEditDialog.value = true;
};

const openDeleteDialog = (user: User) => {
    selectedUser.value = user;
    showDeleteDialog.value = true;
};

const createUser = () => {
    processing.value = true;
    router.post('/dashboard/users', createForm.value, {
        preserveScroll: true,
        onSuccess: () => {
            showCreateDialog.value = false;
            createForm.value = {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            };
        },
        onFinish: () => {
            processing.value = false;
        },
    });
};

const updateUser = () => {
    if (!selectedUser.value) return;

    processing.value = true;
    router.put(`/dashboard/users/${selectedUser.value.id}`, editForm.value, {
        preserveScroll: true,
        onSuccess: () => {
            showEditDialog.value = false;
            selectedUser.value = null;
        },
        onFinish: () => {
            processing.value = false;
        },
    });
};

const deleteUser = () => {
    if (!selectedUser.value) return;

    processing.value = true;
    router.delete(`/dashboard/users/${selectedUser.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteDialog.value = false;
            selectedUser.value = null;
        },
        onFinish: () => {
            processing.value = false;
        },
    });
};

const sortBy = (field: string) => {
    const direction = props.filters.sort === field && props.filters.direction === 'asc' ? 'desc' : 'asc';
    router.get('/dashboard/users', {
        search: search.value,
        sort: field,
        direction
    }, { preserveState: true });
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <Head title="User Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
                        <UsersIcon class="h-6 w-6 text-primary" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">User Management</h1>
                        <p class="text-sm text-muted-foreground">
                            Manage system users and their access
                        </p>
                    </div>
                </div>
                <Button @click="openCreateDialog" class="gap-2">
                    <Plus class="h-4 w-4" />
                    Add User
                </Button>
            </div>

            <!-- Search and Filters -->
            <Card>
                <CardContent class="pt-6">
                    <div class="flex items-center gap-4">
                        <div class="relative flex-1">
                            <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                            <Input
                                v-model="search"
                                placeholder="Search users by name or email..."
                                class="pl-9"
                            />
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Users Table -->
            <Card>
                <CardHeader>
                    <CardTitle>Users ({{ users.total }})</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-3 text-left text-sm font-medium">
                                        <button
                                            @click="sortBy('name')"
                                            class="flex items-center gap-2 hover:text-primary"
                                        >
                                            Name
                                            <ArrowUpDown class="h-4 w-4" />
                                        </button>
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">
                                        <button
                                            @click="sortBy('email')"
                                            class="flex items-center gap-2 hover:text-primary"
                                        >
                                            Email
                                            <ArrowUpDown class="h-4 w-4" />
                                        </button>
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">
                                        <button
                                            @click="sortBy('created_at')"
                                            class="flex items-center gap-2 hover:text-primary"
                                        >
                                            Joined
                                            <ArrowUpDown class="h-4 w-4" />
                                        </button>
                                    </th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="user in users.data"
                                    :key="user.id"
                                    class="border-b last:border-0 hover:bg-muted/50"
                                >
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-sm font-medium text-primary">
                                                {{ user.name.charAt(0).toUpperCase() }}
                                            </div>
                                            <div>
                                                <div class="font-medium">{{ user.name }}</div>
                                                <div v-if="user.id === page.props.auth.user.id" class="text-xs text-muted-foreground">
                                                    (You)
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ user.email }}</td>
                                    <td class="px-4 py-3 text-sm text-muted-foreground">
                                        {{ formatDate(user.created_at) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-2">
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                @click="openEditDialog(user)"
                                            >
                                                <Pencil class="h-4 w-4" />
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                @click="openDeleteDialog(user)"
                                                :disabled="user.id === page.props.auth.user.id"
                                                class="text-destructive hover:text-destructive"
                                            >
                                                <Trash2 class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="users.data.length === 0">
                                    <td colspan="4" class="px-4 py-8 text-center text-muted-foreground">
                                        No users found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="users.last_page > 1" class="mt-4 flex items-center justify-between border-t pt-4">
                        <div class="text-sm text-muted-foreground">
                            Showing {{ (users.current_page - 1) * users.per_page + 1 }} to
                            {{ Math.min(users.current_page * users.per_page, users.total) }} of
                            {{ users.total }} users
                        </div>
                        <div class="flex gap-2">
                            <Button
                                v-for="link in users.links"
                                :key="link.label"
                                :variant="link.active ? 'default' : 'outline'"
                                size="sm"
                                :disabled="!link.url"
                                @click="link.url && router.get(link.url)"
                            >
                                <span v-html="link.label"></span>
                            </Button>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- Create User Dialog -->
        <Dialog v-model:open="showCreateDialog">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Create New User</DialogTitle>
                    <DialogDescription>
                        Add a new user to the system. They will be able to log in with their credentials.
                    </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="createUser" class="space-y-4">
                    <div>
                        <label class="text-sm font-medium">Name</label>
                        <Input v-model="createForm.name" placeholder="John Doe" required />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <Input v-model="createForm.email" type="email" placeholder="john@example.com" required />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <Input v-model="createForm.password" type="password" placeholder="••••••••" required />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Confirm Password</label>
                        <Input v-model="createForm.password_confirmation" type="password" placeholder="••••••••" required />
                    </div>
                    <DialogFooter>
                        <Button type="button" variant="outline" @click="showCreateDialog = false" :disabled="processing">
                            Cancel
                        </Button>
                        <Button type="submit" :disabled="processing">
                            {{ processing ? 'Creating...' : 'Create User' }}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>

        <!-- Edit User Dialog -->
        <Dialog v-model:open="showEditDialog">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Edit User</DialogTitle>
                    <DialogDescription>
                        Update user information. Leave password fields empty to keep the current password.
                    </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="updateUser" class="space-y-4">
                    <div>
                        <label class="text-sm font-medium">Name</label>
                        <Input v-model="editForm.name" placeholder="John Doe" required />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <Input v-model="editForm.email" type="email" placeholder="john@example.com" required />
                    </div>
                    <div>
                        <label class="text-sm font-medium">New Password (optional)</label>
                        <Input v-model="editForm.password" type="password" placeholder="••••••••" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Confirm New Password</label>
                        <Input v-model="editForm.password_confirmation" type="password" placeholder="••••••••" />
                    </div>
                    <DialogFooter>
                        <Button type="button" variant="outline" @click="showEditDialog = false" :disabled="processing">
                            Cancel
                        </Button>
                        <Button type="submit" :disabled="processing">
                            {{ processing ? 'Updating...' : 'Update User' }}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>

        <!-- Delete User Dialog -->
        <Dialog v-model:open="showDeleteDialog">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Delete User</DialogTitle>
                    <DialogDescription>
                        Are you sure you want to delete this user? This action cannot be undone.
                    </DialogDescription>
                </DialogHeader>
                <div v-if="selectedUser" class="rounded-lg border p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-destructive/10 text-destructive">
                            {{ selectedUser.name.charAt(0).toUpperCase() }}
                        </div>
                        <div>
                            <div class="font-medium">{{ selectedUser.name }}</div>
                            <div class="text-sm text-muted-foreground">{{ selectedUser.email }}</div>
                        </div>
                    </div>
                </div>
                <DialogFooter>
                    <Button type="button" variant="outline" @click="showDeleteDialog = false" :disabled="processing">
                        Cancel
                    </Button>
                    <Button type="button" variant="destructive" @click="deleteUser" :disabled="processing">
                        {{ processing ? 'Deleting...' : 'Delete User' }}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>

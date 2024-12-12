<template>
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Liste des Tâches</h1>

    <div class="mb-4">
      <input
        v-model="newTodo.title"
        placeholder="Nouvelle tâche"
        class="border p-2 mr-2"
      />
      <select v-model="newTodo.priority" class="border p-2 mr-2">
        <option value="low">Basse</option>
        <option value="medium">Moyenne</option>
        <option value="high">Haute</option>
      </select>
      <button
        @click="addTodo"
        class="bg-blue-500 text-white p-2 rounded"
      >
        Ajouter
      </button>
    </div>

    <div class="space-y-2">
      <div
        v-for="todo in todos"
        :key="todo.id"
        class="flex items-center justify-between border p-2 rounded"
      >
        <div class="flex items-center">
          <input
            type="checkbox"
            v-model="todo.completed"
            @change="updateTodo(todo)"
            class="mr-2"
          />
          <span
            :class="{
              'line-through text-gray-500': todo.completed,
              'text-red-500': todo.priority === 'high',
              'text-yellow-500': todo.priority === 'medium'
            }"
          >
            {{ todo.title }}
          </span>
        </div>
        <button
          @click="deleteTodo(todo)"
          class="text-red-500"
        >
          Supprimer
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      todos: [],
      newTodo: {
        title: '',
        priority: 'medium'
      }
    }
  },
  methods: {
    async fetchTodos() {
      try {
        const response = await axios.get('/api/todos');
        this.todos = response.data;
      } catch (error) {
        console.error('Erreur lors de la récupération des tâches', error);
      }
    },
    async addTodo() {
      if (!this.newTodo.title.trim()) return;

      try {
        const response = await axios.post('/api/todos', this.newTodo);
        this.todos.push(response.data);
        this.newTodo.title = '';
      } catch (error) {
        console.error('Erreur lors de l\'ajout de la tâche', error);
      }
    },
    async updateTodo(todo) {
      try {
        await axios.put(`/api/todos/${todo.id}`, {
          title: todo.title,
          completed: todo.completed,
          priority: todo.priority
        });
      } catch (error) {
        console.error('Erreur lors de la mise à jour', error);
      }
    },
    async deleteTodo(todo) {
      try {
        await axios.delete(`/api/todos/${todo.id}`);
        this.todos = this.todos.filter(t => t.id !== todo.id);
      } catch (error) {
        console.error('Erreur lors de la suppression', error);
      }
    }
  },
  mounted() {
    this.fetchTodos();
  }
}
</script>

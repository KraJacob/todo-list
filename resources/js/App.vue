<template>
    <div class="container mx-auto p-4 max-w-2xl">
        <h1 class="text-3xl font-bold mb-6 text-center"></h1>

        <!-- Card du formulaire -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="mb-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="task-title" class="block text-sm font-medium text-gray-700 mb-1">Nom de la
                            tâche</label>
                        <input id="task-title" v-model="newTodo.title" placeholder="Nouvelle tâche"
                            class="border rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <div>
                        <label for="task-priority" class="block text-sm font-medium text-gray-700 mb-1">Priorité</label>
                        <select id="task-priority" v-model="newTodo.priority"
                            class="border rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="low">Basse</option>
                            <option value="medium">Moyenne</option>
                            <option value="high">Haute</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <button @click="addTodo"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        Ajouter
                    </button>
                </div>
            </div>
        </div>

        <h1 class="text-3xl font-bold mb-6 text-center">Liste des Tâches</h1>

        <!-- Card de la liste des tâches -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="space-y-3">
                <div v-for="todo in todos" :key="todo.id"
                    class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 border-b last:border-b-0 transition duration-200">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" v-model="todo.completed" @change="updateTodo(todo)"
                            class="w-4 h-4 text-blue-500 rounded focus:ring-blue-500" />
                        <span :class="{
                'line-through text-gray-500': todo.completed,
                'text-red-500 font-medium': todo.priority === 'high',
                'text-yellow-600 font-medium': todo.priority === 'medium',
                'text-gray-600': todo.priority === 'low'
              }">
                            {{ todo.title }}
                        </span>
                    </div>
                    <button @click="deleteTodo(todo)"
                        class="text-red-500 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 transition duration-200">
                        Supprimer
                    </button>
                </div>
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
          if (confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')) {
              try {
                  await axios.delete(`/api/todos/${todo.id}`);
                  this.todos = this.todos.filter(t => t.id !== todo.id);
              } catch (error) {
                  console.error('Erreur lors de la suppression', error);
              }
          }
    }
  },
  mounted() {
    this.fetchTodos();
  }
}
</script>

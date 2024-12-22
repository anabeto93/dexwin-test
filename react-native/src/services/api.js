import axios from 'axios';

const API_URL = 'https://dexwin-test.fly.dev/api/v1';

const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Add request interceptor
api.interceptors.request.use(
  (config) => {
    console.log('🚀 API Request:', {
      method: config.method.toUpperCase(),
      url: config.baseURL + config.url,
      data: config.data,
      headers: config.headers,
    });
    return config;
  },
  (error) => {
    console.error('❌ Request Error:', error);
    return Promise.reject(error);
  }
);

// Add response interceptor
api.interceptors.response.use(
  (response) => {
    console.log('✅ API Response:', response);
    // Unwrap the nested data structure from Laravel
    if (response.data && response.data.data) {
      response.data = response.data.data;
    }
    return response;
  },
  (error) => {
    console.error('❌ Response Error:', {
      message: error.message,
      status: error.response?.status,
      data: error.response?.data,
      config: {
        method: error.config?.method,
        url: error.config?.baseURL + error.config?.url,
        data: error.config?.data,
      },
    });
    return Promise.reject(error);
  }
);

export const getTasks = async (status = '') => {
  try {
    console.log('📝 Fetching tasks with status:', status || 'all');
    const response = await api.get(`/todos${status ? `?status=${status}` : ''}`);
    return response;
  } catch (error) {
    console.error('❌ Error in getTasks:', error.message);
    throw error;
  }
};

export const getTask = async (id) => {
  try {
    console.log('📝 Fetching task with id:', id);
    const response = await api.get(`/todos/${id}`);
    return response.data;
  } catch (error) {
    console.error('❌ Error in getTask:', error.message);
    throw error;
  }
};

export const createTask = async (taskData) => {
  try {
    console.log('📝 Creating task with data:', taskData);
    const response = await api.post('/todos', taskData);
    return response.data;
  } catch (error) {
    console.error('❌ Error in createTask:', error.message);
    throw error;
  }
};

export const updateTask = async (id, taskData) => {
  try {
    console.log('📝 Updating task:', id, 'with data:', taskData);
    const response = await api.put(`/todos/${id}`, taskData);
    return response.data;
  } catch (error) {
    console.error('❌ Error in updateTask:', error.message);
    throw error;
  }
};

export const deleteTask = async (id) => {
  try {
    console.log('📝 Deleting task:', id);
    await api.delete(`/todos/${id}`);
    return true;
  } catch (error) {
    console.error('❌ Error in deleteTask:', error.message);
    throw error;
  }
};

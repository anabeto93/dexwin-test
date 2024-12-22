import React, { useState, useEffect } from 'react';
import { View, FlatList, StyleSheet, ActivityIndicator, Alert } from 'react-native';
import { Button, ButtonGroup, Text } from '@rneui/themed';
import { getTasks, deleteTask } from '../services/api';
import TaskCard from '../components/TaskCard';

const TaskListScreen = ({ navigation }) => {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [selectedIndex, setSelectedIndex] = useState(0);
  const statusFilters = ['all', 'not started', 'in progress', 'completed'];

  const fetchTasks = async (status = '') => {
    try {
      setLoading(true);
      setError(null);
      console.log(' Fetching tasks with status:', status || 'all');
      const response = await getTasks(status);
      console.log(' Fetched tasks:', response.data);
      setTasks(response.data.data || []);
    } catch (error) {
      console.error(' Error in fetchTasks:', error);
      setError('Failed to fetch tasks. Please try again.');
      Alert.alert(
        'Error',
        'Failed to fetch tasks. Please check your connection and try again.',
        [{ text: 'OK' }]
      );
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    const unsubscribe = navigation.addListener('focus', () => {
      fetchTasks(statusFilters[selectedIndex] === 'all' ? '' : statusFilters[selectedIndex]);
    });

    return unsubscribe;
  }, [navigation, selectedIndex]);

  const handleFilterChange = (index) => {
    setSelectedIndex(index);
    fetchTasks(statusFilters[index] === 'all' ? '' : statusFilters[index]);
  };

  const handleViewTask = (task) => {
    navigation.navigate('TaskDetail', { task });
  };

  const handleEditTask = (task) => {
    navigation.navigate('TaskForm', { task });
  };

  const handleDeleteTask = async (taskId) => {
    try {
      await deleteTask(taskId);
      fetchTasks(statusFilters[selectedIndex] === 'all' ? '' : statusFilters[selectedIndex]);
    } catch (error) {
      console.error(' Error deleting task:', error);
      Alert.alert(
        'Error',
        'Failed to delete task. Please try again.',
        [{ text: 'OK' }]
      );
    }
  };

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" color="#0000ff" />
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <ButtonGroup
        buttons={statusFilters.map(status => status.toUpperCase())}
        selectedIndex={selectedIndex}
        onPress={handleFilterChange}
        containerStyle={styles.filterContainer}
      />
      
      {error ? (
        <View style={styles.errorContainer}>
          <Text style={styles.errorText}>{error}</Text>
          <Button
            title="Retry"
            onPress={() => fetchTasks(statusFilters[selectedIndex] === 'all' ? '' : statusFilters[selectedIndex])}
            type="outline"
            containerStyle={styles.retryButton}
          />
        </View>
      ) : tasks.length === 0 ? (
        <View style={styles.emptyContainer}>
          <Text style={styles.emptyText}>No tasks found</Text>
        </View>
      ) : (
        <FlatList
          data={tasks}
          renderItem={({ item }) => (
            <TaskCard
              task={item}
              onView={handleViewTask}
              onEdit={handleEditTask}
              onDelete={handleDeleteTask}
            />
          )}
          keyExtractor={(item) => item.id.toString()}
          contentContainerStyle={styles.listContainer}
        />
      )}
      
      <Button
        title="Create New Task"
        onPress={() => navigation.navigate('TaskForm')}
        containerStyle={styles.createButtonContainer}
        buttonStyle={styles.createButton}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  errorContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 20,
  },
  errorText: {
    color: 'red',
    textAlign: 'center',
    marginBottom: 20,
  },
  retryButton: {
    width: 200,
  },
  emptyContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  emptyText: {
    fontSize: 16,
    color: '#666',
  },
  filterContainer: {
    marginVertical: 10,
    marginHorizontal: 10,
    height: 40,
  },
  listContainer: {
    padding: 10,
  },
  createButtonContainer: {
    position: 'absolute',
    bottom: 20,
    left: 20,
    right: 20,
  },
  createButton: {
    borderRadius: 25,
    height: 50,
  },
});

export default TaskListScreen;

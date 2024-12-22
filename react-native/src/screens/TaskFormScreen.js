import React, { useState } from 'react';
import { View, ScrollView, StyleSheet, Text } from 'react-native';
import { Input, Button, ButtonGroup } from '@rneui/themed';
import { createTask, updateTask } from '../services/api';

const TaskFormScreen = ({ route, navigation }) => {
  const editTask = route.params?.task;
  const [title, setTitle] = useState(editTask?.title || '');
  const [description, setDescription] = useState(editTask?.details || '');
  const [selectedIndex, setSelectedIndex] = useState(
    editTask ? ['not started', 'in progress', 'completed'].indexOf(editTask.status) : 0
  );
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});

  const statusOptions = ['not started', 'in progress', 'completed'];

  const validateForm = () => {
    const newErrors = {};
    if (!title.trim()) {
      newErrors.title = 'Title is required';
    }
    if (!description.trim()) {
      newErrors.description = 'Description is required';
    }
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleSubmit = async () => {
    if (!validateForm()) return;

    try {
      setLoading(true);
      const taskData = {
        title: title.trim(),
        details: description.trim(),
        status: statusOptions[selectedIndex],
      };

      console.log('📝 Submitting task data:', taskData);

      if (editTask) {
        await updateTask(editTask.id, taskData);
      } else {
        await createTask(taskData);
      }

      navigation.goBack();
    } catch (error) {
      console.error('❌ Error saving task:', error);
      const errorMessage = error.response?.data?.message || 'Failed to save task. Please try again.';
      setErrors({ submit: errorMessage });
    } finally {
      setLoading(false);
    }
  };

  return (
    <ScrollView style={styles.container}>
      <View style={styles.form}>
        <Input
          label="Title"
          value={title}
          onChangeText={setTitle}
          placeholder="Enter task title"
          errorMessage={errors.title}
          disabled={loading}
        />

        <Input
          label="Description"
          value={description}
          onChangeText={setDescription}
          placeholder="Enter task description"
          multiline
          numberOfLines={4}
          errorMessage={errors.description}
          disabled={loading}
        />

        <Text style={styles.label}>Status:</Text>
        <ButtonGroup
          buttons={statusOptions.map(status => status.toUpperCase())}
          selectedIndex={selectedIndex}
          onPress={setSelectedIndex}
          containerStyle={styles.statusContainer}
          disabled={loading}
        />

        {errors.submit && (
          <Text style={styles.errorText}>{errors.submit}</Text>
        )}

        <Button
          title={editTask ? "Update Task" : "Create Task"}
          onPress={handleSubmit}
          loading={loading}
          containerStyle={styles.submitButtonContainer}
          buttonStyle={styles.submitButton}
        />
        
        <Button
          title="Cancel"
          onPress={() => navigation.goBack()}
          type="outline"
          disabled={loading}
          containerStyle={styles.cancelButtonContainer}
          buttonStyle={styles.cancelButton}
        />
      </View>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  form: {
    padding: 20,
  },
  label: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#86939e',
    marginBottom: 10,
    marginLeft: 10,
  },
  statusContainer: {
    marginBottom: 20,
    marginHorizontal: 0,
  },
  errorText: {
    color: 'red',
    textAlign: 'center',
    marginBottom: 10,
  },
  submitButtonContainer: {
    marginBottom: 10,
  },
  submitButton: {
    borderRadius: 25,
    height: 50,
  },
  cancelButtonContainer: {
    marginBottom: 20,
  },
  cancelButton: {
    borderRadius: 25,
    height: 50,
  },
});

export default TaskFormScreen;

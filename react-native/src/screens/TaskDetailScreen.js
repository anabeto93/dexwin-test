import React from 'react';
import { View, ScrollView, StyleSheet } from 'react-native';
import { Text, Card, Button } from '@rneui/themed';

const TaskDetailScreen = ({ route, navigation }) => {
  const { task } = route.params;

  const getStatusColor = (status) => {
    switch (status) {
      case 'pending':
        return '#FFA500';
      case 'in_progress':
        return '#4169E1';
      case 'done':
        return '#32CD32';
      default:
        return '#808080';
    }
  };

  return (
    <ScrollView style={styles.container}>
      <Card containerStyle={styles.card}>
        <Card.Title style={styles.title}>{task.title}</Card.Title>
        <View style={styles.content}>
          <Text style={styles.label}>Description:</Text>
          <Text style={styles.description}>{task.description}</Text>
          
          <Text style={styles.label}>Status:</Text>
          <View style={[styles.statusBadge, { backgroundColor: getStatusColor(task.status) }]}>
            <Text style={styles.statusText}>
              {task.status.replace('_', ' ').toUpperCase()}
            </Text>
          </View>
        </View>
        
        <View style={styles.buttonContainer}>
          <Button
            title="Edit Task"
            onPress={() => navigation.navigate('TaskForm', { task })}
            buttonStyle={styles.editButton}
          />
          <Button
            title="Back to List"
            onPress={() => navigation.goBack()}
            type="outline"
            buttonStyle={styles.backButton}
          />
        </View>
      </Card>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  card: {
    borderRadius: 10,
    margin: 10,
    padding: 15,
  },
  title: {
    fontSize: 24,
    marginBottom: 20,
  },
  content: {
    marginBottom: 20,
  },
  label: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#666',
    marginBottom: 5,
  },
  description: {
    fontSize: 16,
    marginBottom: 15,
    lineHeight: 24,
  },
  statusBadge: {
    alignSelf: 'flex-start',
    paddingHorizontal: 15,
    paddingVertical: 8,
    borderRadius: 20,
    marginTop: 5,
  },
  statusText: {
    color: 'white',
    fontSize: 14,
    fontWeight: 'bold',
  },
  buttonContainer: {
    marginTop: 20,
  },
  editButton: {
    marginBottom: 10,
    borderRadius: 25,
    height: 50,
  },
  backButton: {
    borderRadius: 25,
    height: 50,
  },
});

export default TaskDetailScreen;

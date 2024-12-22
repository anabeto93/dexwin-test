import React from 'react';
import { View, StyleSheet } from 'react-native';
import { Card, Text, Button } from '@rneui/themed';

const TaskCard = ({ task, onView, onEdit, onDelete }) => {
  const getStatusColor = (status) => {
    switch (status) {
      case 'not started':
        return '#FFA500';
      case 'in progress':
        return '#4169E1';
      case 'completed':
        return '#32CD32';
      default:
        return '#808080';
    }
  };

  return (
    <Card containerStyle={styles.card}>
      <Card.Title>{task.title}</Card.Title>
      <View style={styles.content}>
        <Text style={styles.description} numberOfLines={2}>
          {task.details}
        </Text>
        <View style={[styles.statusBadge, { backgroundColor: getStatusColor(task.status) }]}>
          <Text style={styles.statusText}>{task.status.toUpperCase()}</Text>
        </View>
      </View>
      <View style={styles.buttonContainer}>
        <Button
          type="clear"
          title="View"
          onPress={() => onView(task)}
          titleStyle={styles.buttonText}
        />
        <Button
          type="clear"
          title="Edit"
          onPress={() => onEdit(task)}
          titleStyle={styles.buttonText}
        />
        <Button
          type="clear"
          title="Delete"
          onPress={() => onDelete(task.id)}
          titleStyle={[styles.buttonText, styles.deleteButton]}
        />
      </View>
    </Card>
  );
};

const styles = StyleSheet.create({
  card: {
    borderRadius: 10,
    marginBottom: 10,
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 3.84,
    elevation: 5,
  },
  content: {
    marginBottom: 10,
  },
  description: {
    marginBottom: 10,
    color: '#666',
  },
  statusBadge: {
    alignSelf: 'flex-start',
    paddingHorizontal: 10,
    paddingVertical: 5,
    borderRadius: 15,
  },
  statusText: {
    color: 'white',
    fontSize: 12,
    fontWeight: 'bold',
  },
  buttonContainer: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    marginTop: 10,
  },
  buttonText: {
    fontSize: 14,
  },
  deleteButton: {
    color: '#FF0000',
  },
});

export default TaskCard;

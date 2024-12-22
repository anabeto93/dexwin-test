import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { ThemeProvider } from '@rneui/themed';
import TaskListScreen from './src/screens/TaskListScreen';
import TaskDetailScreen from './src/screens/TaskDetailScreen';
import TaskFormScreen from './src/screens/TaskFormScreen';

const Stack = createNativeStackNavigator();

export default function App() {
  return (
    <ThemeProvider>
      <NavigationContainer>
        <Stack.Navigator
          initialRouteName="TaskList"
          screenOptions={{
            headerStyle: {
              backgroundColor: '#2089dc',
            },
            headerTintColor: '#fff',
            headerTitleStyle: {
              fontWeight: 'bold',
            },
          }}
        >
          <Stack.Screen
            name="TaskList"
            component={TaskListScreen}
            options={{ title: 'Task Manager' }}
          />
          <Stack.Screen
            name="TaskDetail"
            component={TaskDetailScreen}
            options={{ title: 'Task Details' }}
          />
          <Stack.Screen
            name="TaskForm"
            component={TaskFormScreen}
            options={({ route }) => ({
              title: route.params?.task ? 'Edit Task' : 'Create Task',
            })}
          />
        </Stack.Navigator>
      </NavigationContainer>
    </ThemeProvider>
  );
}

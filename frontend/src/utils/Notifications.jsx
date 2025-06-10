import { showNotification } from '@mantine/notifications'
import { IconCheck, IconX, IconAlertTriangle, IconInfoCircle } from '@tabler/icons-react'

const NotificationBase = ({ message, icon, color, themeColor }) => {
	showNotification({
		message: <span>{message}</span>,
		icon,
		color,
		autoClose: 3500,
		transition: 'slide-down',
		position: 'top-left',
		styles: (theme) => ({
			root: {
				width: 'clamp(300px, 90%, 700px)',
				backgroundColor: theme.colors[themeColor][0],
				border: `1px solid ${theme.colors[themeColor][5]}`,
				borderRadius: theme.radius.lg,
				padding: '1rem 1.25rem',
				boxShadow: '0 4px 12px rgba(0, 0, 0, 0.05)',
				display: 'flex',
				alignItems: 'center',
				gap: '1rem'
			},
			description: {
				color: theme.colors[themeColor][8],
				fontSize: '1rem',
				flex: 1
			},
			icon: {
				minWidth: '24px',
				minHeight: '24px'
			}
		})
	});
};

const Success = (message) => NotificationBase({
	message,
	icon: <IconCheck size={20} />,
	color: 'green',
	themeColor: 'success'
});

const Error = (message) => NotificationBase({
	message,
	icon: <IconX size={20} />,
	color: 'red',
	themeColor: 'danger'
});

const Warning = (message) => NotificationBase({
	message,
	icon: <IconAlertTriangle size={20} />,
	color: 'orange',
	themeColor: 'accent'
});

const Info = (message) => NotificationBase({
	message,
	icon: <IconInfoCircle size={20} />,
	color: 'blue',
	themeColor: 'grayblue'
});

const Notifications = { Success, Error, Warning, Info };
export default Notifications;
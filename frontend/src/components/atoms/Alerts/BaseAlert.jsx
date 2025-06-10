import { Alert } from '@mantine/core'

const BaseAlert = ({ children, color, title, icon, ...props }) => (
    <Alert
        withCloseButton
        icon={icon}
        title={title}
        color={color}
        radius='md'
        {...props}
    >
        {children}
    </Alert>
)

export default BaseAlert;
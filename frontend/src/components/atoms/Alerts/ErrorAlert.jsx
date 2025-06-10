import BaseAlert from './BaseAlert.jsx'
import { IconAlertCircle } from '@tabler/icons-react'

const ErrorAlert = ({ children, title = '', iconSize = 18, ...props }) => (
    <BaseAlert title={title} color='red' icon={<IconAlertCircle size={iconSize} />} {...props}>
        {children}
    </BaseAlert>
)

export default ErrorAlert;
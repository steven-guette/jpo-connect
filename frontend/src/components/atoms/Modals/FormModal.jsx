import { Modal as MantineModal } from '@mantine/core'

const FormModal = ({ children, onClose, opened }) => (
	<MantineModal
		opened={opened}
		onClose={onClose}
		centered
		trapFocus={false}
		size="lg"
		padding="lg"
		transitionProps={{
			transition: 'fade',
			duration: 200
		}}
	>
		{children}
	</MantineModal>
)

export default FormModal;
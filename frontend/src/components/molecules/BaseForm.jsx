import { Stack, Group } from '@mantine/core'

import PrimaryButton from '../atoms/Buttons/PrimaryButton'
import SecondaryButton from '../atoms/Buttons/SecondaryButton'
import FormTitle from '../atoms/Titles/FormTitle'
import FormErrorList from './FormErrorList'

const BaseForm = ({
      children,
      title,
      onClose,
      error,
      onSubmit,
      loading,
      buttonText = "Envoyer",
      canCancel = false,
      cancelEvent = null
}) => {
    return (
        <form onSubmit={onSubmit}>
            <Stack>
                <FormTitle children={title} />
                <FormErrorList errors={error} onClose={onClose} />
                {children}
                <Group position='right' mt='sm'>
                    <PrimaryButton type="submit" children={buttonText} loading={loading} />
                    {canCancel && (
                        <SecondaryButton onClick={cancelEvent} children="Annuler" />
                    )}
                </Group>
            </Stack>
        </form>
    )
}

export default BaseForm;
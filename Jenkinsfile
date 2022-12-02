pipeline{
    agent kubernetes {
        label 'jenkins-slave'
        defaultContainer 'jnlp'
        yaml '''
        apiVersion: v1
        kind: Pod
        spec:
          containers:
          - name: shell
            image: ubuntu
            command:
            - sleep
            args:
            - infinity
        '''
    }

    stages {
        stage('Cleaning'){
            steps{
                cleanWs()
                checkout scm
            }
        }
        stage('Verification') {
            steps {
                validateDeclarativePipeline 'Jenkinsfile'
                sh 'php -v'
                sh 'php -i'
            }
        }
        stage('Write .env [prod]') {
             steps{

                withCredentials([file(credentialsId: 'env-rescue-panel-prod', variable: 'envfile')]) {
                writeFile file: '.env', text: readFile(envfile)
                }
            }
        }

        stage('Build & tag container') {
            steps {
                sh "docker build --build-arg user=pannel --build-arg uid=45 -t simonloudev/rescue-panel:latest ."
                sh "docker tag simonloudev/rescue-panel:latest simonloudev/rescue-panel:$SENTRY_RELEASE"
            }
        }

        stage('Clean'){
            steps{
                cleanWs()
            }
        }

    }
}
